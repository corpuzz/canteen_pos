<!-- Billing Header -->
<div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center space-x-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm4 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
    </svg>
    <h2 class="text-lg font-semibold text-orange-600 dark:text-orange-400">Billing Details</h2>
</div>

<!-- Billing Items -->
<div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-800 flex flex-col">
    <div class="space-y-4 p-4 flex-grow">
        @forelse($currentTransaction->order_items as $item)
            <div class="bg-white dark:bg-gray-800 shadow-md flex items-center gap-4 py-3 px-4 rounded-xl">
                <!-- Product Image -->
                @php
                    $productId = $item['id'] ?? $item['product_id'] ?? $item['product_id_id'] ?? null;
                    $billingProduct = $productId ? App\Models\Product::find($productId) : null;
                    $placeholderUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88R8AAtUB6R+hMPIAAAAASUVORK5CYII=';
                    $imageUrl = $billingProduct && $billingProduct->image_url 
                        ? (str_starts_with($billingProduct->image_url, 'http') 
                            ? $billingProduct->image_url 
                            : asset('' . $billingProduct->formatted_image_url)) 
                        : $placeholderUrl;
                @endphp
                <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                    <img src="{{ $imageUrl }}" alt="{{ $item['name'] ?? 'Product' }}" class="w-full h-full object-cover">
                </div>

                <!-- Product Details -->
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ $item['name'] ?? 'Unknown Product' }}
                    </h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        ₱{{ number_format($item['price'] ?? 0, 2) }}
                    </p>
                </div>

                <!-- Item Quantity and Total -->
                <div class="text-right">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        × {{ $item['quantity'] ?? 1 }}
                    </span>
                    <div class="text-sm font-bold text-orange-500">
                        ₱{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                No items in this transaction
            </div>
        @endforelse
    </div>
</div>

<!-- Billing Summary -->
<div class="mt-auto border-t border-gray-200 dark:border-gray-700">
    <div class="p-4 space-y-3">
        <div class="flex justify-between text-sm">
            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
            <span class="text-gray-900 dark:text-gray-100">
                ₱{{ number_format($currentTransaction->subtotal ?? 0, 2) }}
            </span>
        </div>

        @if(($currentTransaction->tax ?? 0) > 0)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                <span class="text-gray-900 dark:text-gray-100">
                    ₱{{ number_format($currentTransaction->tax ?? 0, 2) }}
                </span>
            </div>
        @endif

        <div class="flex justify-between text-base font-bold">
            <span class="text-gray-900 dark:text-gray-100">Total:</span>
            <span class="text-orange-500">
                ₱{{ number_format($currentTransaction->total_amount ?? 0, 2) }}
            </span>
        </div>

        <!-- Payment Method Selection -->
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="paymentMethod" value="cash" 
                           class="form-radio text-orange-500 border-gray-300 focus:ring-orange-500">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Cash</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="paymentMethod" value="gcash" 
                           class="form-radio text-orange-500 border-gray-300 focus:ring-orange-500">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">GCash</span>
                </label>
            </div>
        </div>

        <!-- Payment Amount Input -->
        <div class="mt-4">
            <label for="paymentAmount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Payment Amount
            </label>
            <input 
                type="number" 
                id="paymentAmount" 
                wire:model="paymentAmount" 
                wire:input="calculateChange"
                min="{{ $currentTransaction->total_amount ?? 0 }}"
                step="0.01"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                placeholder="Enter payment amount"
            >
            @error('paymentAmount')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Change Calculation -->
        <div class="flex justify-between text-sm mt-4">
            <span class="text-gray-600 dark:text-gray-400">Change:</span>
            <span class="text-gray-900 dark:text-gray-100">
                ₱{{ number_format($change ?? 0, 2) }}
            </span>
        </div>
    </div>

    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        <button 
            wire:click="processPayment" 
            class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors"
            {{ !$paymentMethod || !$paymentAmount || $paymentAmount < ($currentTransaction->total_amount ?? 0) ? 'disabled' : '' }}
        >
            Complete Payment
        </button>
    </div>
</div>