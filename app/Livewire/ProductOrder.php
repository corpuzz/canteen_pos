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
    public $selectedCategory = 'All';
    public $orderType = 'dine-in';
    public $cart = [];
    public $categories = [];
    public $quantities = [];
    public $selectedCartItems = [];
    public $selectAll = false;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        // Select all existing cart items by default
        $this->selectedCartItems = collect($this->cart)
            ->mapWithKeys(fn($item, $productId) => [$productId => true])
            ->toArray();
        $this->quantities = array_fill_keys(array_keys($this->cart), 1);
        
        // Fetch categories
        $this->categories = Product::select('category')
            ->distinct()
            ->pluck('category')
            ->prepend('All')
            ->toArray();
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

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
            // Auto-select newly added items
            $this->selectedCartItems[$productId] = true;
        }

        session()->put('cart', $this->cart);
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
            unset($this->cart[$productId]);
        } else {
            $this->cart[$productId]['quantity'] = $newQuantity;
        }

        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function processOrder()
    {
        if (empty($this->selectedCartItems)) return;

        // Remove processed items from cart
        foreach ($this->selectedCartItems as $productId => $selected) {
            unset($this->cart[$productId]);
        }

        // Clear selected items
        $this->selectedCartItems = [];
        
        // Update session
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
        
        session()->flash('message', 'Selected orders processed successfully!');
    }

    public function toggleSelectAll()
    {
        if (count($this->selectedCartItems) === count($this->cart)) {
            $this->selectedCartItems = [];
        } else {
            $this->selectedCartItems = collect($this->cart)
                ->mapWithKeys(fn($item, $productId) => [$productId => true])
                ->toArray();
        }
    }

    public function removeSelectedItems()
    {
        // Only remove the items that are currently selected
        foreach ($this->selectedCartItems as $productId => $selected) {
            if ($selected) {
                unset($this->cart[$productId]);
            }
        }
        
        // Clear the selected items
        $this->selectedCartItems = [];
        $this->selectAll = false;
        
        // Update the session
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function getSelectedItemsCountProperty()
    {
        return collect($this->selectedCartItems)
            ->filter(fn($selected) => $selected === true)
            ->count();
    }

    public function getCartTotalProperty()
    {
        return collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    #[Computed]
    public function getSelectedTotalProperty()
    {
        return collect($this->cart)
            ->filter(fn($item, $productId) => !empty($this->selectedCartItems[$productId]))
            ->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function hasSelectedItems()
    {
        return !empty($this->selectedCartItems);
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

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedCartItems = collect($this->cart)
                ->mapWithKeys(fn($item, $productId) => [$productId => true])
                ->toArray();
        } else {
            $this->selectedCartItems = [];
        }
    }

    public function updatedSelectedCartItems()
    {
        // Update select all checkbox state
        $this->selectAll = count($this->selectedCartItems) === count($this->cart);
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
