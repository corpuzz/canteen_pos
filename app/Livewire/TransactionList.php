<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    // public function render()
    // {
    //     $query = Transaction::query()
    //         ->where('user_id', Auth::id())  // Always filter by current user
    //         ->when($this->search, function($query) {
    //             $query->where(function($q) {
    //                 $q->where('transaction_number', 'like', '%' . $this->search . '%')
    //                   ->orWhere('cashier_name', 'like', '%' . $this->search . '%')
    //                   ->orWhere('total_amount', 'like', '%' . $this->search . '%')
    //                   ->orWhere(DB::raw("DATE_FORMAT(created_at, '%M %d, %Y')"), 'like', '%' . $this->search . '%');
    //             });
    //         })
    //         ->when($this->dateRange, function($query) {
    //             // Add date range filtering if needed
    //         })
    //         ->latest()
    //         ->paginate(10);

    //     return view('livewire.transaction-list', [
    //         'transactions' => $query
    //     ]);
    // }
    // public function render()
    // {
    //     $query = Transaction::query()
    //         ->when(!Auth::user()->isAdmin(), function ($query) {
    //             // If user is NOT an admin, filter by current user
    //             $query->where('user_id', Auth::id());
    //         })
    //         ->when($this->search, function ($query) {
    //             $query->where(function ($q) {
    //                 $q->where('transaction_number', 'like', '%' . $this->search . '%')
    //                     ->orWhere('cashier_name', 'like', '%' . $this->search . '%')
    //                     ->orWhere('total_amount', 'like', '%' . $this->search . '%')
    //                     ->orWhere(DB::raw("DATE_FORMAT(created_at, '%M %d, %Y')"), 'like', '%' . $this->search . '%');
    //             });
    //         })
    //         ->when($this->dateRange, function ($query) {
    //             // Add date range filtering if needed
    //         })
    //         ->latest()
    //         ->paginate(10);

    //     return view('livewire.transaction-list', [
    //         'transactions' => $query
    //     ]);
    // }
    public function render()
    {
        $currentRoute = request()->route() ? request()->route()->getName() : null;
    
        $query = Transaction::query()
            ->when(
                // If user is NOT an admin, always show only their transactions
                !Auth::user()->isAdmin() ||
                // If admin is on home route, show only their transactions
                ($currentRoute === 'home' && Auth::user()->isAdmin()) ||
                // If admin is on dashboard route, show ALL transactions
                ($currentRoute === 'dashboard' && Auth::user()->isAdmin()),
                function ($query) use ($currentRoute) {
                    // Conditions for filtering transactions
                    if ($currentRoute === 'dashboard' && Auth::user()->isAdmin()) {
                        // On dashboard, admin sees ALL transactions
                        return $query;
                    } else {
                        // On other routes or for non-admins, show only current user's transactions
                        $query->where('user_id', Auth::id());
                    }
                }
            )
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_number', 'like', '%' . $this->search . '%')
                        ->orWhere('cashier_name', 'like', '%' . $this->search . '%')
                        ->orWhere('total_amount', 'like', '%' . $this->search . '%')
                        ->orWhere(DB::raw("DATE_FORMAT(created_at, '%M %d, %Y')"), 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->dateRange, function ($query) {
                // Add date range filtering if needed
            })
            ->latest()
            ->paginate(10);
    
        return view('livewire.transaction-list', [
            'transactions' => $query
        ]);
    }
}
