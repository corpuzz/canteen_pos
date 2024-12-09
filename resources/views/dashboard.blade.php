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
                                class="tab-button border-b-2 py-4 px-6 font-medium text-sm cursor-pointer transition-colors duration-200"
                                id="products-tab"
                            >
                                Products
                            </button>
                            <button
                                onclick="switchTab('transactions')"
                                class="tab-button border-b-2 py-4 px-6 font-medium text-sm cursor-pointer ml-8 transition-colors duration-200"
                                id="transactions-tab"
                            >
                                Transactions
                            </button>
                            </div>
                            
                            <livewire:create-product-button />
                        </nav>
                    </div>

                    <!-- Tab Contents -->
                    <div class="relative">
                        <div id="products-content" class="tab-content transition-all duration-300 transform">
                            <livewire:product-dashboard />
                        </div>
                        <div id="transactions-content" class="tab-content transition-all duration-300 transform opacity-0 absolute top-0 left-0 w-full invisible">
                            <livewire:transaction-list />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            const productsContent = document.getElementById('products-content');
            const transactionsContent = document.getElementById('transactions-content');
            
            // Update tab styles with transition
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-orange-500', 'text-orange-600', 'dark:text-orange-500');
                button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'hover:border-gray-300');
            document.getElementById(tabName + '-tab').classList.add('border-orange-500', 'text-orange-600', 'dark:text-orange-500');

            // Handle content transitions
            if (tabName === 'products') {
                // Fade out transactions
                transactionsContent.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => {
                    transactionsContent.classList.add('invisible');
                    // Fade in products
                    productsContent.classList.remove('opacity-0', 'invisible', '-translate-x-4');
                }, 300);
            } else {
                // Fade out products
                productsContent.classList.add('opacity-0', '-translate-x-4');
                setTimeout(() => {
                    productsContent.classList.add('invisible');
                    // Fade in transactions
                    transactionsContent.classList.remove('opacity-0', 'invisible', 'translate-x-4');
                }, 300);
            }
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
