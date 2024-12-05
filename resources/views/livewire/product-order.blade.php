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
            <nav class="flex-1 p-4 bg-gray-100 dark:bg-gray-900 ">
                <div class=" space-y-2">
                    <a href="#" class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900">
                        Menu
                    </a>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900">
                        Transactions
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
                                        @php
                                            $placeholderUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88R8AAtUB6R+hMPIAAAAASUVORK5CYII=';
                                            $imageUrl = $product->image_url 
                                                ? (str_starts_with($product->image_url, 'http') 
                                                    ? $product->image_url 
                                                    : asset('storage/' . $product->formatted_image_url))
                                                : $placeholderUrl;
                                        @endphp
                                        <img 
                                            src="{{ $imageUrl }}"
                                            alt="{{ $product->name }}" 
                                            class="w-full h-full object-cover"
                                        >
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
            <div class="flex flex-col h-full">
                <!-- Cart Header -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cart</h2>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-800">
                    <div class="space-y-4 p-4">
                        @forelse($cart as $productId => $item)
                            <div class="bg-white dark:bg-gray-800 shadow-md flex items-center gap-4 py-3 px-4 rounded-xl">
                                <!-- Selection Checkbox -->
                                <div class="flex-shrink-0">
                                    <input 
                                        type="checkbox" 
                                        wire:model.live="selectedCartItems.{{ $productId }}"
                                        class="w-4 h-4 text-coral-600 border-gray-300 rounded focus:ring-coral-500"
                                    >
                                </div>

                                <!-- Product Image -->
                                @php
                                    $cartProduct = App\Models\Product::find($productId);
                                    $placeholderUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88R8AAtUB6R+hMPIAAAAASUVORK5CYII=';
                                    $imageUrl = $cartProduct && $cartProduct->image_url 
                                        ? (str_starts_with($cartProduct->image_url, 'http') 
                                            ? $cartProduct->image_url 
                                            : asset('storage/' . $cartProduct->image_url))
                                        : $placeholderUrl;
                                @endphp
                                <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                                    <img 
                                        src="{{ $imageUrl }}"
                                        alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                                
                                <!-- Product Details -->
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        ₱{{ number_format($item['price'], 2) }}
                                    </p>
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-2 mt-2">
                                        <button 
                                            wire:click="updateQuantity({{ $productId }}, -1)"
                                            class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900"
                                        >
                                            -
                                        </button>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click="updateQuantity({{ $productId }}, 1)"
                                            class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-coral-100 dark:hover:bg-coral-900"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Item Total -->
                                <div class="text-right">
                                    <span class="text-sm font-bold text-coral-500">
                                        ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                Your cart is empty
                            </div>
                        @endforelse

                        
                    </div>
                    
                </div>

                <!-- Cart Total -->
                <div class="mt-auto border-t border-gray-200 dark:border-gray-700">
                    <!-- Selected Items Count and Remove Button -->
                    <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $this->selectedItemsCount }} items selected
                        </span>
                        <button 
                            wire:click="removeSelectedItems"
                            class="px-3 py-1 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 disabled:opacity-50"
                            {{ empty($this->selectedCartItems) ? 'disabled' : '' }}
                        >
                            Remove
                        </button>
                    </div>

                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="selectAll"
                                    class="w-4 h-4 text-coral-600 border-gray-300 rounded focus:ring-coral-500"
                                >
                                <span class="text-base font-medium text-gray-900 dark:text-gray-100">Total</span>
                            </div>
                            <span class="text-xl font-bold text-coral-500">
                                ₱{{ number_format($this->selectedTotal, 2) }}
                            </span>
                        </div>
                        <button 
                            wire:click="processOrder"
                            class="w-full px-4 py-2 bg-coral-500 text-white rounded-lg hover:bg-coral-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$this->hasSelectedItems() ? 'disabled' : '' }}
                        >
                            Process Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
