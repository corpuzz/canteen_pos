<?php

namespace App\Livewire;

use Livewire\Component;

class CreateProductButton extends Component
{
    public function toggleCreating()
    {
        $this->dispatch('toggle-creating');
    }

    public function render()
    {
        return view('livewire.create-product-button');
    }
}
