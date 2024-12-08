<x-app-layout>
    <x-slot name="header">
        <!-- <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            
        </div> -->
        
    </x-slot>

    <div class="py-4 bg-zinc-200 dark:bg-gray-900">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-100 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                        <nav class="-mb-px flex justify-between" aria-label="Tabs">
                            <div>
                            <button
                                onclick="switchTab('products')"
                                class="tab-button border-b-2 py-4 px-6 font-medium text-sm cursor-pointer"
                                id="products-tab"
                            >
                                Products
                            </button>
                            <button
                                onclick="switchTab('transactions')"
                                class="tab-button border-b-2 py-4 px-6 font-medium text-sm cursor-pointer ml-8"
                                id="transactions-tab"
                            >
                                Transactions
                            </button>
                            </div>
                            
                            <livewire:create-product-button />
                        </nav>
                    </div>

                    <!-- Tab Contents -->
                    <div id="products-content" class="tab-content">
                        <livewire:product-dashboard />
                    </div>
                    <div id="transactions-content" class="tab-content hidden">
                        <livewire:transaction-list />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');

            // Update tab styles
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-orange-500', 'text-orange-600', 'dark:text-orange-500');
                button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'hover:border-gray-300');
            document.getElementById(tabName + '-tab').classList.add('border-orange-500', 'text-orange-600', 'dark:text-orange-500');
        }

        // Set initial active tab
        document.addEventListener('DOMContentLoaded', () => {
            switchTab('products');
        });

        // Listen for showProducts event
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('showProducts', () => {
                switchTab('products');
            });
        });
    </script>
</x-app-layout>
