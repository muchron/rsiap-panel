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
    protected $primaryKey = 'code';      // Sesuaikan dengan ERD (kolom code)
    public $incrementing = false;
    protected $keyType = 'string';

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'polyclinic_code', 'code');
    }
}
