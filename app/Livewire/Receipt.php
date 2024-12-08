<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class Receipt extends Component
{
    public $transaction;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function closeReceipt()
    {
        $this->dispatch('receiptClosed');
    }

    public function render()
    {
        return view('livewire.receipt');
    }
}
