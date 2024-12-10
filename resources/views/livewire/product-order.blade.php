@php
use Illuminate\Support\Str;
@endphp

<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Left Sidebar -->
    <div class="w-64 bg-white dark:bg-gray-800 shadow-lg">
        <div class="h-full flex flex-col">
            <!-- Logo -->
            <div class="p-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-3 text-orange-500" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 13V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v10a6 6 0 0 1-6 6H7a4 4 0 0 1-4-4v-2h12" />
                        <path d="M8 15a4 4 0 1 0 8 0 4 4 0 1 0 -8 0" />
                        <path d="M10 13.5V10a2 2 0 1 1 4 0v3.5" />
                    </svg>
                    <h1 class="text-2xl font-bold text-orange-600 dark:text-orange-400">Canteen POS</h1>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 bg-gray-100 dark:bg-gray-900">
                <div class="space-y-2">
                    <a wire:click="setActiveTab('menu')"  class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-orange-400 dark:hover:bg-orange-900 hover:text-zinc-100 dark:hover:text-zinc-100 cursor-pointer flex items-center space-x-2 {{ $activeTab === 'menu' ? 'bg-orange-400 dark:bg-orange-900 text-zinc-100' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Menu</span>
                    </a>
                    <a wire:click="setActiveTab('transactions')"  class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-orange-400 dark:hover:bg-orange-900 hover:text-zinc-100 dark:hover:text-zinc-100 cursor-pointer flex items-center space-x-2 {{ $activeTab === 'transactions' ? 'bg-orange-400 dark:bg-orange-900 text-zinc-100' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        <span>Transactions</span>
                    </a>
                    @if(Auth::user()->is_admin)
                    <a href="{{ route('dashboard')}}" class="block px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-orange-400 dark:hover:bg-orange-900 hover:text-zinc-100 dark:hover:text-zinc-100 cursor-pointer flex items-center space-x-2 {{ $activeTab === 'dashboard' ? 'bg-orange-400 dark:bg-orange-900 text-zinc-100' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect x="3" y="3" width="7" height="7" rx="1" />
    <rect x="14" y="3" width="7" height="7" rx="1" />
    <rect x="3" y="14" width="7" height="7" rx="1" />
    <rect x="14" y="14" width="7" height="7" rx="1" />
</svg>
                        <span>Dashboard</span>
                    </a>
                    @endif
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
                        <a @click.prevent="showLogoutModal = true" href="#" class="text-gray-500 dark:text-gray-400 hover:text-orange-500 dark:hover:text-orange-400 transition-colors cursor-pointer" title="Logout">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </a>

                        <!-- Logout Confirmation Modal -->
                        <div x-show="showLogoutModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div x-show="showLogoutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showLogoutModal = false" aria-hidden="true"></div>

                                <!-- Modal panel -->
                                <div x-show="showLogoutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
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
                                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-500 text-base font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm" @click="document.getElementById('logout-form').submit()">
                                            Logout
                                        </button>
                                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showLogoutModal = false">
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

    <!-- Main Content Area -->
    <div class="flex-1 flex">
        @if($activeTab === 'menu')
            <!-- Menu Content (Left Side) -->
            <div  class="flex-1">
                <!-- Search and Categories -->
                <div class="p-4 bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto">
                        <!-- Search -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                wire:model.live="search" 
                                type="text" 
                                placeholder="Search products..." 
                                class="w-full pl-10 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-orange-500 focus:border-orange-500"
                            >
                        </div>

                        <!-- Categories -->
                        <div class="mt-4 flex flex-wrap gap-2 mb-4">
                            <button 
                                wire:click="$set('selectedCategory', 'All')" 
                                class="px-4 py-2 rounded-lg transition-colors duration-300 
                                    {{ $selectedCategory === 'All' || !$selectedCategory
        ? 'bg-orange-500 text-white'
        : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}
                                    active:bg-orange-600 active:scale-95"
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
                : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}
                                            active:bg-orange-600 active:scale-95"
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
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 flex space-x-4">
                                <!-- Product Image -->
                                <div class="w-36 h-36 rounded-xl bg-gray-100 dark:bg-gray-700 overflow-hidden flex-shrink-0">
                                    @php
        $placeholderUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88R8AAtUB6R+hMPIAAAAASUVORK5CYII=';
        $imageUrl = $product->image_url ? (str_starts_with($product->image_url, 'http') ? $product->image_url : asset($product->image_url)) : $placeholderUrl;
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 flex flex-col">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</h3>
                                        
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-2 line-clamp-2 flex-grow">{{ $product->description }}</p>

                                    <div class="mt-auto w-full flex justify-between">

                                        <button wire:click="addToCart({{ $product->id }})" class="w-7/12 px-4 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition-colors text-center text-sm font-medium">
                                            Add to Cart
                                        </button>
                                    <span class="text-xl font-bold mx-2 text-orange-600 dark:text-orange-400">₱{{ number_format($product->price, 2) }}</span>

                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Section (Right Sidebar) -->
            <div class="w-96 bg-white dark:bg-gray-800 shadow-lg border-l border-gray-200 dark:border-gray-700 flex flex-col">
                @if($viewToShow === 'cart')
                    @include('livewire.cart')
                @elseif($viewToShow === 'billing')
                    @include('livewire.billing')
                @else
                    @include('livewire.receipt')
                @endif
            </div>
        @else
            <!-- Transactions Content (Right Side) -->
            <div class="flex-1 overflow-y-auto">
                <livewire:transaction-list />
            </div>
        @endif
    </div>
</div>
