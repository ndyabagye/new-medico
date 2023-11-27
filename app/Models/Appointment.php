<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Appointment $appointment) {
            $appointment->created_by = auth()->id();
            $appointment->updated_by = auth()->id();
        });

        static::updating(function (Appointment $appointment) {
            $appointment->updated_by = auth()->id();
        });
    }

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'name',
        'institution',
        'department',
        'appointment_start_time',
        'appointment_end_time',
        'notes',
        'description',
        'created_by',
        'updated_by',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
