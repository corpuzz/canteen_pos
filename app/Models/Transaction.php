<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_number',
        'cashier_name',
        'subtotal',
        'tax',
        'total_amount',
        'order_items',
        'payment_method',
        'amount_paid',
        'change',
        'user_id'
    ];

    protected $casts = [
        'order_items' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
