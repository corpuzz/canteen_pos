<div class="{{ request()->routeIs('dashboard') ? 'px-6 py-0' : 'px-6 py-6' }}">
    <!-- Search Bar -->
    <div class="mb-6 grid grid-cols-12 gap-4">
            <div class="relative col-span-12 flex-grow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 absolute top-1/2 transform -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live="search" type="search" placeholder="Search Transactions..." class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm sm:leading-6 h-10">
            </div>
            
        </div>

    <!-- Transactions Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200 dark:gray-700">
            <thead class="bg-gray-5000 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Transaction #
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Cashier
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            {{ $transaction->transaction_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            {{ $transaction->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            {{ $transaction->cashier_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ₱{{ number_format($transaction->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button 
                                wire:click="viewTransaction({{ $transaction->id }})"
                                class="text-orange-600 hover:text-orange-900 dark:text-orange-400 dark:hover:text-orange-300"
                            >
                                View Details
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>

    <!-- Transaction Details Modal -->
    @if($showTransactionDetails && $selectedTransaction)
    <div class=" fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-max w-max max-h-[90vh] overflow-y-auto shadow-xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Transaction Details</h2>
                    <button 
                        wire:click="closeTransactionDetails"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Transaction #:</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $selectedTransaction->transaction_number }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Date:</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $selectedTransaction->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Cashier:</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $selectedTransaction->cashier_name }}</p>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Items:</p>
                        <div class="space-y-2">
                            @foreach($selectedTransaction->order_items as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ $item['name'] }} x {{ $item['quantity'] }}
                                    </span>
                                    <span class="text-gray-900 dark:text-gray-100">
                                        ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($selectedTransaction->subtotal, 2) }}</span>
                        </div>
                        @if($selectedTransaction->tax > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                                <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($selectedTransaction->tax, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm font-bold">
                            <span class="text-gray-900 dark:text-gray-100">Total:</span>
                            <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($selectedTransaction->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Payment:</span>
                            <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($selectedTransaction->amount_paid, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Change:</span>
                            <span class="text-gray-900 dark:text-gray-100">₱{{ number_format($selectedTransaction->change, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
