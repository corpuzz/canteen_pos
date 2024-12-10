<!-- Cart Header -->
<div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center space-x-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500 dark:text-orange-400" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    <h2 class="text-lg font-semibold text-orange-600 dark:text-orange-400">Cart</h2>
</div>

<!-- Cart Items -->
<div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-800 flex flex-col">
    <div class="space-y-4 p-4 flex-grow">
        @forelse($cart as $productId => $item)
                <div class="bg-white dark:bg-gray-800 shadow-md flex items-center gap-4 py-3 px-4 rounded-xl">
                    <!-- Selection Checkbox -->
                    <div class="flex-shrink-0">
                        <input type="checkbox" wire:model.live="selectedCartItems.{{ $productId }}"
                            class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                    </div>

                    <!-- Product Image -->
                    @php
                        $cartProduct = App\Models\Product::find($productId);
                        $placeholderUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88R8AAtUB6R+hMPIAAAAASUVORK5CYII=';
                        $imageUrl = $cartProduct && $cartProduct->image_url ? (str_starts_with($cartProduct->image_url, 'http') ? $cartProduct->image_url : asset('' . $cartProduct->formatted_image_url)) : $placeholderUrl;
                    @endphp
                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                        <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item['name'] }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            ₱{{ number_format($item['price'], 2) }}
                        </p>
                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-2 mt-2">
                            <button wire:click="updateQuantity({{ $productId }}, -1)"
                                class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-orange-100 dark:hover:bg-orange-900">
                                -
                            </button>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $item['quantity'] }}</span>
                            <button wire:click="updateQuantity({{ $productId }}, 1)"
                                class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-orange-100 dark:hover:bg-orange-900">
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
        <button wire:click="removeSelectedItems"
            class="px-3 py-1 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 disabled:opacity-50"
            {{ empty($this->selectedCartItems) ? 'disabled' : '' }}>
            Remove
        </button>
    </div>

    <div class="p-4 space-y-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <input type="checkbox" wire:model.live="selectAll"
                    class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                <span class="text-base font-medium text-gray-900 dark:text-gray-100">Total</span>
            </div>
            <span class="text-xl font-bold text-orange-500">
                ₱{{ number_format($this->selectedTotal, 2) }}
            </span>
        </div>
        <button wire:click="processOrder"
            class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            {{ !$this->hasSelectedItems() ? 'disabled' : '' }}>
            Process Order
        </button>
    </div>
</div>