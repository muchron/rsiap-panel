<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $fillable = ['title', 'image', 'is_active'];
    protected $hidden = ['deleted_at'];

}
