<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $with = [
        'users',
        'court'
    ];

    public function users()
    {
        return $this->hasMany(AppointmentUser::class, "appointment_id", "id");
    }

    public function court()
    {
        return $this->hasOne(Court::class, 'id', 'court_id');
    }
}
