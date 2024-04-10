<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $with = [
        'users',
        'teacher',
        'member',
        'court',
        'status'
    ];

    // get the teacher depending on the role id of the user (docent role)
    public function teacher()
    {
        return $this->hasOne(AppointmentUser::class, "appointment_id", "id")->whereHas('user', function ($query) { 
            $query->where('role_id', 2);
        })->orderBy("created_at", "ASC");
    }


    // get the member its always the last added member in appointment_user 
    // only when its a lesson its the teacher but then you don't show the member
    public function member()
    {
        return $this->hasOne(AppointmentUser::class, "appointment_id", "id")->orderBy("created_at", "DESC");
    }

    public function users()
    {
        return $this->hasMany(AppointmentUser::class, "appointment_id", "id");
    }

    public function court()
    {
        return $this->hasOne(Court::class, 'id', 'court_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
