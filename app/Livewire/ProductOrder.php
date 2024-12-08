<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\SavedCart;
use App\Models\Transaction;
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
    public $searchQuery = '';
    public $showReceipt = false;
    public $currentTransaction;

    public function mount()
    {
        // Load cart items from database
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        
        foreach ($cartItems as $cartItem) {
            $this->cart[$cartItem->product_id] = [
                'id' => $cartItem->product_id,
                'name' => $cartItem->product->name,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->quantity
            ];
        }
        
        session()->put('cart', $this->cart);
        $this->selectedCartItems = [];

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
        
        if (!$product) {
            return;
        }

        // Create or update cart item in database
        $cartItem = auth()->user()->cartItems()->updateOrCreate(
            ['product_id' => $productId],
            ['quantity' => isset($this->cart[$productId]) ? $this->cart[$productId]['quantity'] + 1 : 1]
        );

        // Update local cart
        $this->cart[$productId] = [
            'id' => $productId,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $cartItem->quantity
        ];

        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($productId)
    {
        // Remove from database
        auth()->user()->cartItems()->where('product_id', $productId)->delete();

        // Remove from local cart
        unset($this->cart[$productId]);
        unset($this->selectedCartItems[$productId]);
        
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function removeSelectedItems()
    {
        foreach ($this->selectedCartItems as $productId => $selected) {
            if ($selected) {
                unset($this->cart[$productId]);
                unset($this->selectedCartItems[$productId]);
            }
        }

        // Update saved cart in database
        if (empty($this->cart)) {
            // If cart is empty, delete the saved cart
            SavedCart::where('user_id', auth()->id())
                ->where('is_processed', false)
                ->delete();
        } else {
            // Update the existing cart
            SavedCart::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'is_processed' => false
                ],
                [
                    'cart_data' => $this->cart
                ]
            );
        }

        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
        $this->selectAll = false;
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->selectedCartItems = [];
        
        // Delete saved cart
        SavedCart::where('user_id', auth()->id())
            ->where('is_processed', false)
            ->delete();

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

        // Update saved cart
        SavedCart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'is_processed' => false
            ],
            [
                'cart_data' => $this->cart
            ]
        );

        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function processOrder()
    {
        if (empty($this->selectedCartItems)) return;

        // Create transaction
        $selectedItems = collect($this->cart)
            ->filter(fn($item, $id) => isset($this->selectedCartItems[$id]))
            ->map(function($item, $id) {
                return [
                    'id' => $id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ];
            })->values()->all();
    
        $subtotal = collect($selectedItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = 0; // You can modify this based on your tax calculation logic
        $totalAmount = $subtotal + $tax;
        
        $transaction = Transaction::create([
            'transaction_number' => 'TXN-' . Str::random(10),
            'cashier_name' => auth()->user()->name,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total_amount' => $totalAmount,
            'order_items' => $selectedItems,
            'payment_method' => 'Cash',
            'amount_paid' => $totalAmount,
            'change' => 0
        ]);
    
        // Remove processed items from cart
        $this->cart = [];
        $this->selectedCartItems = [];
        
        // Clear cart items from database
        auth()->user()->cartItems()->delete();
        
        // Update session
        session()->put('cart', $this->cart);
        
        // Show receipt
        $this->currentTransaction = $transaction;
        $this->showReceipt = true;
    
        $this->dispatch('cart-updated');
    }

    #[On('receiptClosed')]
    public function closeReceipt()
    {
        $this->showReceipt = false;
        $this->currentTransaction = null;
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;
        
        foreach ($this->cart as $productId => $item) {
            $this->selectedCartItems[$productId] = $this->selectAll;
        }
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
        $this->updateSelectAllState();
    }

    private function updateSelectAllState()
    {
        if (empty($this->cart)) {
            $this->selectAll = false;
            return;
        }

        $this->selectAll = count(array_filter($this->selectedCartItems)) === count($this->cart);
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
