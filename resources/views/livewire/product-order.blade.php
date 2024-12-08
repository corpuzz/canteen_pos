@php
    use Illuminate\Support\Str;
@endphp

<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Left Sidebar -->
    <div class="w-64 bg-white dark:bg-gray-800 shadow-lg">
        <div class="h-full flex flex-col">
            <!-- Logo -->
            <div class="p-4">
                <h1 class="text-2xl font-bold text-orange-600 dark:text-orange-400">Canteen POS</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 bg-gray-100 dark:bg-gray-900 ">
                <div class=" space-y-2">
                    <a href="#" class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-orange-400 dark:hover:bg-orange-900">
                        Menu
                    </a>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-orange-400 dark:hover:bg-orange-900">
                        Transactions
                    </a>
                </div>
            </nav>

            <!-- User Profile at Bottom -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between space-x-3">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ auth()->user()->name ?? 'User' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ auth()->user()->email ?? 'user@example.com' }}
                            </p>
                        </div>
                    </div>
                    
                    <div x-data="{ showLogoutModal: false }">
                        <a 
                            @click.prevent="showLogoutModal = true"
                            href="#"
                            class="text-gray-500 dark:text-gray-400 hover:text-orange-500 dark:hover:text-orange-400 transition-colors cursor-pointer"
                            title="Logout"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </a>

                        <!-- Logout Confirmation Modal -->
                        <div
                            x-show="showLogoutModal"
                            x-cloak
                            class="fixed inset-0 z-50 overflow-y-auto"
                            aria-labelledby="modal-title"
                            role="dialog"
                            aria-modal="true"
                        >
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div
                                    x-show="showLogoutModal"
                                    x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    @click="showLogoutModal = false"
                                    aria-hidden="true"
                                ></div>

                                <!-- Modal panel -->
                                <div
                                    x-show="showLogoutModal"
                                    x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                >
                                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                                    Confirm Logout
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Are you sure you want to log out? Any unsaved changes will be lost.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button
                                            type="button"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-500 text-base font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm"
                                            @click="document.getElementById('logout-form').submit()"
                                        >
                                            Logout
                                        </button>
                                        <button
                                            type="button"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                            @click="showLogoutModal = false"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
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
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-orange-500 focus:border-orange-500"
                        >
                    </div>

                    <!-- Categories -->
                    <div class="mt-4 flex flex-wrap gap-2 mb-4">
                    <button 
                            wire:click="$set('selectedCategory', 'All')"
                            class="px-4 py-2 rounded-lg transition-colors duration-300 
                                {{ $selectedCategory === 'All' 
                                    ? 'bg-orange-500 text-white' 
                                    : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}"
                        >
                            All
                        </button>
                        @foreach($categories as $category)
                            @if($category !== 'All')
                                <button 
                                    wire:click="$set('selectedCategory', '{{ $category }}')"
                                    class="px-4 py-2 rounded-lg transition-colors duration-300 
                                        {{ $selectedCategory === $category 
                                            ? 'bg-orange-500 text-white' 
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}"
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
                                                    : asset($product->formatted_image_url))
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
                                            <span class="text-xl font-bold text-orange-500 whitespace-nowrap ml-auto">₱{{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quantity and Add to Cart -->
                                <div class="space-y-2">
                
                                    <button 
                                        wire:click="addToCart({{ $product->id }})"
                                        class="w-full px-4 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors text-center text-sm font-medium"
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

            @if($showReceipt)
                <div class="bg-white dark:bg-gray-800 p-6 w-full h-full flex flex-col">
                    <div class="flex-1 overflow-auto">
                        <div class="text-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ 'Canteen POS' }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Transaction Receipt</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $currentTransaction->created_at->format('M d, Y h:i A') }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Transaction #: {{ $currentTransaction->transaction_number }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cashier: {{ $currentTransaction->cashier_name }}</p>
                        </div>

                        <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4 mb-4">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-sm text-gray-600 dark:text-gray-400">
                                        <th class="text-left">Item</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($currentTransaction->order_items as $item)
                                        <tr class="text-sm">
                                            <td class="text-left text-gray-900 dark:text-gray-100">{{ $item['name'] }}</td>
                                            <td class="text-right text-gray-900 dark:text-gray-100">{{ $item['quantity'] }}</td>
                                            <td class="text-right text-gray-900 dark:text-gray-100">₱{{ number_format($item['price'], 2) }}</td>
                                            <td class="text-right text-gray-900 dark:text-gray-100">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-2 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($currentTransaction->subtotal, 2) }}</span>
                            </div>
                            @if($currentTransaction->tax > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                                    <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($currentTransaction->tax, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-base font-bold">
                                <span class="text-gray-900 dark:text-gray-100">Total:</span>
                                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($currentTransaction->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Payment:</span>
                                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($currentTransaction->amount_paid, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Change:</span>
                                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($currentTransaction->change, 2) }}</span>
                            </div>
                        </div>

                        <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                            <p>Thank you for your purchase!</p>
                            <p>Please come again</p>
                        </div>
                    </div>

                    <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <button 
                            wire:click="closeReceipt"
                            class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors"
                        >
                            Done
                        </button>
                    </div>
                </div>
            @else
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
                                        class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500"
                                    >
                                </div>

                                <!-- Product Image -->
                                @php
                                    $cartProduct = App\Models\Product::find($productId);
                                    $placeholderUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88R8AAtUB6R+hMPIAAAAASUVORK5CYII=';
                                    $imageUrl = $cartProduct && $cartProduct->image_url 
                                        ? (str_starts_with($cartProduct->image_url, 'http') 
                                            ? $cartProduct->image_url 
                                            : asset('' . $cartProduct->formatted_image_url))
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
                                            class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-orange-100 dark:hover:bg-orange-900"
                                        >
                                            -
                                        </button>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click="updateQuantity({{ $productId }}, 1)"
                                            class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-orange-100 dark:hover:bg-orange-900"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Item Total -->
                                <div class="text-right">
                                    <span class="text-sm font-bold text-orange-500">
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
                                    class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500"
                                >
                                <span class="text-base font-medium text-gray-900 dark:text-gray-100">Total</span>
                            </div>
                            <span class="text-xl font-bold text-orange-500">
                                ₱{{ number_format($this->selectedTotal, 2) }}
                            </span>
                        </div>
                        <button 
                            wire:click="processOrder"
                            class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$this->hasSelectedItems() ? 'disabled' : '' }}
                        >
                            Process Order
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
