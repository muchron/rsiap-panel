<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'desc', 'price', 'image', 'features', 'color_theme', 'is_available', 'class', 'category'];

    protected $casts = [
        'features' => 'array',
        'is_available' => 'boolean',
    ];

    protected $hidden = ['deleted_at'];

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
