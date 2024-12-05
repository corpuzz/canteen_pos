<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductOrder extends Component
{
    use WithFileUploads;

    public $search = '';
    public $selectedCategory = '';
    public $orderType = 'dine-in';
    public $cart = [];
    public $categories = [];
    public $quantities = [];

    public function mount()
    {
        $this->categories = array_merge(['All'], Product::distinct('category')->pluck('category')->toArray());
        $this->cart = session()->get('cart', []);
        $this->initializeQuantities();
    }

    public function initializeQuantities()
    {
        $products = $this->products;
        foreach ($products as $product) {
            if (!isset($this->quantities[$product->id])) {
                $this->quantities[$product->id] = 1;
            }
        }
    }

    public function getProductsProperty()
    {
        return Product::when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory && $this->selectedCategory !== 'All', function($query) {
                $query->where('category', $this->selectedCategory);
            })
            ->where('is_available', true)
            ->get();
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category === $this->selectedCategory ? '' : $category;
    }

    public function incrementQuantity($productId)
    {
        if (!isset($this->quantities[$productId])) {
            $this->quantities[$productId] = 1;
        } else {
            $this->quantities[$productId]++;
        }
    }

    public function decrementQuantity($productId)
    {
        if (isset($this->quantities[$productId]) && $this->quantities[$productId] > 1) {
            $this->quantities[$productId]--;
        }
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;

        $quantity = $this->quantities[$productId] ?? 1;

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $quantity;
        } else {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $this->cart);
        $this->quantities[$productId] = 1; // Reset quantity after adding to cart
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function updateQuantity($productId, $change)
    {
        if (!isset($this->cart[$productId])) return;

        $newQuantity = $this->cart[$productId]['quantity'] + $change;
        
        if ($newQuantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }

        $this->cart[$productId]['quantity'] = $newQuantity;
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function getCartTotalProperty()
    {
        return collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function getFormattedImageUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        // If it's a full URL, return as-is
        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        // Remove any leading slashes
        $url = ltrim($url, '/');

        // Try storage path first
        $storagePath = asset('storage/' . $url);
        
        // If storage path doesn't work, try public path
        $publicPath = asset('images/' . $url);

        return $storagePath;
    }

    public function render()
    {
        return view('livewire.product-order', [
            'products' => $this->products->map(function($product) {
                $product->formatted_image_url = $this->getFormattedImageUrl($product->image_url);
                return $product;
            })
        ]);
    }
}
