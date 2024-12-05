@php
    use Illuminate\Support\Str;
@endphp

<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Left Sidebar -->
    <div class="w-64 bg-white dark:bg-gray-800 shadow-lg">
        <div class="h-full flex flex-col">
            <!-- Logo -->
            <div class="p-4">
                <h1 class="text-2xl font-bold text-coral-600 dark:text-coral-400">Canteen POS</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <div class="space-y-2">
                    <a href="#" class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900">
                        Orders
                    </a>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900">
                        Dashboard
                    </a>
                </div>
            </nav>

            <!-- User Profile at Bottom -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-coral-500 flex items-center justify-center text-white">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? 'email@example.com' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex">
        <div class="flex-1 overflow-hidden">
            <!-- Search and Categories -->
            <div class="p-4 bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto">
                    <!-- Search -->
                    <div class="relative">
                        <input 
                            wire:model.live="search" 
                            type="text" 
                            placeholder="Search products..." 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-coral-500 focus:border-coral-500"
                        >
                    </div>

                    <!-- Categories -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <button 
                            wire:click="selectCategory('All')"
                            class="px-4 py-2 rounded-lg {{ $selectedCategory === 'All' ? 'bg-coral-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} hover:bg-coral-400 dark:hover:bg-coral-600 transition-colors"
                        >
                            All
                        </button>
                        @foreach($categories as $category)
                            @if($category !== 'All')
                                <button 
                                    wire:click="selectCategory('{{ $category }}')"
                                    class="px-4 py-2 rounded-lg {{ $selectedCategory === $category ? 'bg-coral-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} hover:bg-coral-400 dark:hover:bg-coral-600 transition-colors"
                                >
                                    {{ $category }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="p-4 overflow-auto" style="height: calc(100vh - 180px);">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
                            <div class="flex flex-col">
                                <div class="flex space-x-4 mb-4">
                                    <!-- Product Image -->
                                    <div class="w-28 h-28 rounded-xl bg-gray-100 dark:bg-gray-700 overflow-hidden flex-shrink-0">
                                        @if($product->image_url)
                                            <img 
                                                src="{{ $product->formatted_image_url ?? 'https://placehold.co/400x300/png?text=' . urlencode($product->name) }}"
                                                alt="{{ $product->name }}" 
                                                class="w-full h-full object-cover"
                                                onerror="this.src='https://placehold.co/400x300/png?text={{ urlencode($product->name) }}'"
                                            >
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm text-center px-2">
                                                {{ $product->name }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1 flex flex-col overflow-hidden">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate pr-2">{{ $product->name }}</h3>
                                        </div>
                                        
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                        <div class="flex items-center space-x-2">
                                            <div class="flex w-1/2 items-center bg-gray-100 dark:bg-gray-700 rounded-full">
                                                <button 
                                                    wire:click="decrementQuantity({{ $product->id }})" 
                                                    class="w-8 h-8 flex items-center justify-center rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600"
                                                >
                                                    -
                                                </button>
                                                <span class="w-8 text-center text-gray-800 dark:text-gray-200">{{ $quantities[$product->id] ?? 1 }}</span>
                                                <button 
                                                    wire:click="incrementQuantity({{ $product->id }})" 
                                                    class="w-8 h-8 flex items-center justify-center rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600"
                                                >
                                                    +
                                                </button>
                                            </div>
                                            <span class="text-xl font-bold text-coral-500 whitespace-nowrap ml-auto">₱{{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quantity and Add to Cart -->
                                <div class="space-y-2">
                
                                    <button 
                                        wire:click="addToCart({{ $product->id }})"
                                        class="w-full px-4 py-2 bg-coral-500 text-white rounded-full hover:bg-coral-600 transition-colors text-center text-sm font-medium"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Cart -->
        <div class="w-96 bg-white dark:bg-gray-800 shadow-lg">
            <div class="h-full flex flex-col">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Your Order</h2>
                    
                    <!-- Order Type Selection -->
                    <div class="mt-4">
                        <div class="flex rounded-lg overflow-hidden border border-gray-300 dark:border-gray-700">
                            <button 
                                wire:click="$set('orderType', 'dine-in')" 
                                class="flex-1 px-4 py-2 {{ $orderType === 'dine-in' ? 'bg-coral-500 text-white' : 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300' }}"
                            >
                                Dine In
                            </button>
                            <button 
                                wire:click="$set('orderType', 'take-out')" 
                                class="flex-1 px-4 py-2 {{ $orderType === 'take-out' ? 'bg-coral-500 text-white' : 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300' }}"
                            >
                                Take Out
                            </button>
                            <button 
                                wire:click="$set('orderType', 'delivery')" 
                                class="flex-1 px-4 py-2 {{ $orderType === 'delivery' ? 'bg-coral-500 text-white' : 'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300' }}"
                            >
                                Delivery
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-auto p-4">
                    @if(empty($cart))
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            Your cart is empty
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($cart as $id => $item)
                                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-900 p-3 rounded-lg">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item['name'] }}</h4>
                                        <p class="text-sm text-coral-600 dark:text-coral-400">₱{{ number_format($item['price'], 2) }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            wire:click="updateQuantity({{ $id }}, -1)"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900"
                                        >
                                            -
                                        </button>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click="updateQuantity({{ $id }}, 1)"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Cart Total -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total</span>
                        <span class="text-xl font-bold text-coral-600 dark:text-coral-400">₱{{ number_format($this->cartTotal, 2) }}</span>
                    </div>
                    <button 
                        class="w-full px-4 py-2 bg-coral-500 text-white rounded-lg hover:bg-coral-600 transition-colors"
                        {{ empty($cart) ? 'disabled' : '' }}
                    >
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
