<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_code', 'first_name', 'last_name', 'middle_name',
        'birthdate', 'gender', 'phone', 'email', 'address'
    ];

    public function visits() {
        return $this->hasMany(Visit::class);
    }

    public function claims() {
        return $this->hasMany(Claim::class);
    }

    public function insurances() {
        return $this->hasMany(PatientInsurance::class);
    }
}
