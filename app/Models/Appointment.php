<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'phone_number',
        'email',
        'booking_date',
        'city',
        'speciality',
        'doctor',
        'gender',
        'age',
        'details',
        'appointment_status',
    ];
}
