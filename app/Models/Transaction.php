<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'change'
    ];

    protected $casts = [
        'order_items' => 'array'
    ];
}
