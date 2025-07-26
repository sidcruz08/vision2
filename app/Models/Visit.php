<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'visit_date', 'visit_type', 'reason', 'doctor_name', 'status'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function diagnoses() {
        return $this->hasMany(Diagnosis::class);
    }

    public function treatments() {
        return $this->hasMany(Treatment::class);
    }

    public function claim() {
        return $this->hasOne(Claim::class);
    }
}
