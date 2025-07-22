<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Polyclinic extends Model
{
    /** @use HasFactory<\Database\Factories\PolyclinicFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
}
