<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class SavedCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_data',
        'is_processed'
    ];

    protected $casts = [
        'cart_data' => 'array',
        'is_processed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
