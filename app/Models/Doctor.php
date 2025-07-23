<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'doctor_id');
    }
    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'doctor_id', 'doctor_id');
    }

    public function polyclinic()
    {
        return $this->belongsToMany(Polyclinic::class, 'schedules', 'doctor_id', 'polyclinic_code');
    }
}
