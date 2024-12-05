<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image_url'
    ];

    public function getFormattedImageUrlAttribute()
    {
        if (empty($this->image_url)) {
            return null;
        }

        // If it's a full URL, return as-is
        if (Str::startsWith($this->image_url, ['http://', 'https://'])) {
            return $this->image_url;
        }

        // Remove any leading slashes or 'storage/' prefix
        $cleanPath = ltrim(str_replace('storage/', '', $this->image_url), '/');

        // Return the correct storage path
        return 'storage/' . $cleanPath;
    }
}
