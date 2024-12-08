<div>
    <button 
        wire:click="toggleCreating"
        class="inline-flex items-center mx-6 px-4 py-2 bg-indigo-600 dark:bg-indigo-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-800 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ml-8"
    >
        Create Product
    </button>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('toggle-creating', () => {
                switchTab('products');
            });
        });
    </script>
</div>
