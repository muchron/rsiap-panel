<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labels extends Model
{
    /** @use HasFactory<\Database\Factories\LabelsFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
}
