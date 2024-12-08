<div class="bg-white dark:bg-gray-800 p-6 w-full h-full flex flex-col">
    <div class="flex-1 overflow-auto">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ 'Canteen POS' }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Transaction Receipt</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $transaction->created_at->format('M d, Y h:i A') }}</p>
        </div>

        <div class="mb-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Transaction #: {{ $transaction->transaction_number }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Cashier: {{ $transaction->cashier_name }}</p>
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
                    @foreach($transaction->order_items as $item)
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
                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($transaction->subtotal, 2) }}</span>
            </div>
            @if($transaction->tax > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                    <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($transaction->tax, 2) }}</span>
                </div>
            @endif
            <div class="flex justify-between text-base font-bold">
                <span class="text-gray-900 dark:text-gray-100">Total:</span>
                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($transaction->total_amount, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Payment:</span>
                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($transaction->amount_paid, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Change:</span>
                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($transaction->change, 2) }}</span>
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
