<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg">
        <div class="flex items-center px-6 py-4 border-b">
            <h1 class="text-2xl font-bold text-gray-900">
                <span class="text-coral-500">Purr</span>Coffee
            </h1>
        </div>
        
        <nav class="px-4 py-4">
            <div class="space-y-2">
                <a href="#" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Home page
                </a>
                
                <a href="#" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    My orders
                </a>
                
                <a href="#" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    History
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex">
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <!-- Search -->
                    <div class="flex items-center flex-1 max-w-2xl">
                        <div class="relative w-full">
                            <input 
                                type="text" 
                                wire:model.live="search" 
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-coral-500"
                                placeholder="Search..."
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <button class="ml-4 px-4 py-2 bg-coral-500 text-white rounded-lg hover:bg-coral-600 focus:outline-none">
                            Filter
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center ml-8">
                        @auth
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="User avatar" class="w-8 h-8 rounded-full">
                                <span class="ml-2 text-gray-700">{{ auth()->user()->name }}</span>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-coral-500">Login</a>
                        @endauth
                    </div>
                </div>

                <!-- Categories -->
                <div class="px-8 py-2 border-t flex space-x-4">
                    @foreach($categories as $category)
                        <button 
                            wire:click="$set('selectedCategory', '{{ $category }}')"
                            class="px-4 py-2 rounded-lg {{ $selectedCategory === $category ? 'bg-coral-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}"
                        >
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            </header>

            <!-- Products Grid -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $selectedCategory }} menu</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow p-6 flex">
                            <div class="w-32 h-32 flex-shrink-0">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                            </div>
                            <div class="ml-6 flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                                        <p class="text-coral-500 font-semibold">₱{{ number_format($product->price, 2) }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            wire:click="updateQuantity('{{ $product->id }}', {{ isset($cart[$product->id]) ? $cart[$product->id]['quantity'] - 1 : 0 }})"
                                            class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100"
                                        >
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <span class="text-gray-700">{{ isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0 }}</span>
                                        <button 
                                            wire:click="addToCart('{{ $product->id }}')"
                                            class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100"
                                        >
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">{{ $product->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Cart Sidebar -->
        <div class="w-96 bg-white border-l">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Cart</h2>
                
                <!-- Order Type Selection -->
                <div class="flex rounded-lg border border-gray-300 p-1 mb-6">
                    <button 
                        wire:click="setOrderType('Delivery')"
                        class="flex-1 py-2 text-sm font-medium rounded-md {{ $orderType === 'Delivery' ? 'bg-coral-500 text-white' : 'text-gray-700' }}"
                    >
                        Delivery
                    </button>
                    <button 
                        wire:click="setOrderType('Dine in')"
                        class="flex-1 py-2 text-sm font-medium rounded-md {{ $orderType === 'Dine in' ? 'bg-coral-500 text-white' : 'text-gray-700' }}"
                    >
                        Dine in
                    </button>
                    <button 
                        wire:click="setOrderType('Take away')"
                        class="flex-1 py-2 text-sm font-medium rounded-md {{ $orderType === 'Take away' ? 'bg-coral-500 text-white' : 'text-gray-700' }}"
                    >
                        Take away
                    </button>
                </div>

                <!-- Cart Items -->
                <div class="space-y-4 mb-6">
                    @forelse($cart as $id => $item)
                        <div class="flex items-center">
                            <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg">
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-coral-500">₱{{ number_format($item['price'], 2) }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button 
                                    wire:click="updateQuantity('{{ $id }}', {{ $item['quantity'] - 1 }})"
                                    class="w-6 h-6 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100"
                                >
                                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span class="text-sm text-gray-700">{{ $item['quantity'] }}</span>
                                <button 
                                    wire:click="updateQuantity('{{ $id }}', {{ $item['quantity'] + 1 }})"
                                    class="w-6 h-6 flex items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100"
                                >
                                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">Your cart is empty</p>
                    @endforelse
                </div>

                <!-- Cart Summary -->
                @if(count($cart) > 0)
                    <div class="border-t pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Items</span>
                            <span class="text-sm font-medium text-gray-900">₱{{ number_format($this->cartTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-sm text-gray-600">Discount</span>
                            <span class="text-sm font-medium text-gray-900">-₱0.00</span>
                        </div>
                        <div class="flex justify-between font-medium">
                            <span class="text-gray-900">Total</span>
                            <span class="text-coral-500">₱{{ number_format($this->cartTotal, 2) }}</span>
                        </div>
                        
                        <button class="mt-6 w-full py-3 bg-coral-500 text-white rounded-lg hover:bg-coral-600 focus:outline-none">
                            Place an order
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
