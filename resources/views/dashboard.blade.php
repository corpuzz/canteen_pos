<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Products') }}
            </h2>
            <livewire:create-product-button />
        </div>
    </x-slot>

    <livewire:product-dashboard />
</x-app-layout>
