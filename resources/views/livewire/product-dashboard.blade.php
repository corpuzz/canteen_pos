<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Search and Create Button -->
        <div class="mb-6 grid grid-cols-12 gap-4">
            <div class="relative col-span-9 flex-grow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 absolute top-1/2 transform -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live="search" type="search" placeholder="Search products..." class="pl-10 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm sm:leading-6 h-10">
            </div>
            <div class="col-span-3 flex items-center">
                <select wire:model.live="category" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm sm:leading-6 h-10">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="rounded-md bg-green-50 dark:bg-green-900 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400 dark:text-green-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000-8zM3.707 9.293a1 1 0 011.414 0L9 13.586l4.293-4.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Create/Edit Form -->
        @if($isCreating || $editingProductId)
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <form wire:submit="{{ $editingProductId ? 'update' : 'create' }}">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <x-input-label for="name" :value="__('Product Name')" />
                                <x-text-input wire:model="name" id="name" type="text" class="mt-1 block w-full" required />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-input-label for="category" :value="__('Category')" />
                                <select wire:model="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-input-label for="price" :value="__('Price')" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 dark:text-gray-400">
                                        ₱
                                    </div>
                                    <x-text-input 
                                        wire:model="price" 
                                        id="price" 
                                        type="number" 
                                        step="0.01" 
                                        class="mt-1 block w-full pl-8" 
                                        required 
                                    />
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-input-label for="stock" :value="__('Stock')" />
                                <x-text-input wire:model="stock" id="stock" type="number" class="mt-1 block w-full" required />
                            </div>

                            <div class="col-span-6">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-input-label for="image" :value="__('Product Image')" />
                                
                                <div 
                                    class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 dark:border-gray-600 px-6 py-10"
                                    x-data="{ 
                                        dragOver: false,
                                        handleDrop(e) {
                                            e.preventDefault();
                                            this.dragOver = false;
                                            if (e.dataTransfer.files.length > 0) {
                                                @this.upload('image', e.dataTransfer.files[0]);
                                            }
                                        }
                                    }"
                                    x-on:dragover.prevent="dragOver = true"
                                    x-on:dragleave.prevent="dragOver = false"
                                    x-on:drop="handleDrop($event)"
                                    :class="{ 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20': dragOver }"
                                >
                                    <div class="text-center">
                                        <!-- Preview Area -->
                                        @if ($image || $image_url)
                                            <div class="relative w-48 mx-auto">
                                                <img src="{{ $image ? $image->temporaryUrl() : $image_url }}" 
                                                     class="h-48 w-48 object-cover rounded-lg shadow-lg" 
                                                     alt="Product preview">
                                                <!-- Remove Image Button -->
                                                <button 
                                                    type="button"
                                                    wire:click="removeImage"
                                                    class="absolute -top-3 -right-3 rounded-full bg-red-500 text-white p-1.5 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm"
                                                    title="Remove image"
                                                >
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm18-9.791a.75.75 0 00-1.06-1.06L6.94 19.21a.75.75 0 001.06 1.06l12-12z" clip-rule="evenodd" />
                                            </svg>
                                        @endif

                                        <div class="mt-4 flex flex-col items-center text-sm leading-6 text-gray-600 dark:text-gray-400">
                                            <label for="image" class="relative cursor-pointer rounded-md bg-white dark:bg-gray-800 font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                                                <span>Upload a file</span>
                                                <input 
                                                    type="file" 
                                                    wire:model="image" 
                                                    id="image" 
                                                    class="sr-only"
                                                    accept="image/*"
                                                />
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                            <p class="text-xs leading-5">PNG, JPG, GIF up to 1MB</p>
                                        </div>

                                        <!-- Loading indicator -->
                                        <div wire:loading wire:target="image" class="mt-2">
                                            <div class="inline-flex items-center">
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Uploading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @error('image') 
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-input-label for="image_url" :value="__('Image URL (Optional)')" />
                                <div class="mt-2">
                                    <x-text-input 
                                        wire:model="image_url" 
                                        id="image_url" 
                                        type="url" 
                                        class="block w-full" 
                                        placeholder="https://example.com/image.jpg"
                                    />
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Provide a URL if the image is hosted elsewhere
                                </p>
                            </div>

                            <div class="col-span-6 flex justify-end space-x-4">
                                <button type="button" wire:click="cancelEdit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </button>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ $editingProductId ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Products Table -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                {{ $product->name }}
                                @if($product->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($product->description, 50) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                {{ $product->category }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                ₱{{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                {{ $product->stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button wire:click="startEditing({{ $product->id }})" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $product->id }})" wire:confirm="Are you sure you want to delete this product?" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>