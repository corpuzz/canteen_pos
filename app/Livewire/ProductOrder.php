<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductOrder extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = 'Coffee';
    public $cart = [];
    public $orderType = 'Delivery';

    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);
        
        if (!isset($this->cart[$productId])) {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 0,
                'image_url' => $product->image_url,
            ];
        }
        
        $this->cart[$productId]['quantity'] += $quantity;
        session()->put('cart', $this->cart);
        
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }
        
        $this->cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function setOrderType($type)
    {
        $this->orderType = $type;
    }

    public function getCartTotalProperty()
    {
        return collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        $products = Product::when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function($query) {
                $query->where('category', $this->selectedCategory);
            })
            ->get();

        return view('livewire.product-order', [
            'products' => $products,
            'categories' => ['Coffee', 'Non Coffee', 'Food', 'Snack', 'Dessert'],
        ]);
    }
}
