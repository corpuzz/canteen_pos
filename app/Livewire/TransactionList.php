<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionList extends Component
{
    use WithPagination;

    public $search = '';
    public $dateRange = '';
    public $selectedTransaction = null;
    public $showTransactionDetails = false;

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedDateRange()
    {
        $this->resetPage();
    }

    public function viewTransaction($transactionId)
    {
        $this->selectedTransaction = Transaction::find($transactionId);
        $this->showTransactionDetails = true;
    }

    public function closeTransactionDetails()
    {
        $this->showTransactionDetails = false;
        $this->selectedTransaction = null;
    }

    public function render()
    {
        $query = Transaction::query()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('transaction_number', 'like', '%' . $this->search . '%')
                      ->orWhere('cashier_name', 'like', '%' . $this->search . '%')
                      ->orWhere('total_amount', 'like', '%' . $this->search . '%')
                      ->orWhere(DB::raw("DATE_FORMAT(created_at, '%M %d, %Y')"), 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->dateRange, function($query) {
                // Add date range filtering if needed
            })
            ->latest()
            ->paginate(10);

        return view('livewire.transaction-list', [
            'transactions' => $query
        ]);
    }
}
