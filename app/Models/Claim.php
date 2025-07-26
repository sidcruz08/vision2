<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    // protected $fillable = ['visit_id', 'patient_id', 'claim_number', 'claim_date', 'claim_amount', 'status', 'remarks'];
    protected $casts = [
        'documents' => 'json',
        'dates' => 'json'
    ];

    protected $fillable = [
        'patient_id',
        'documents',
        'dates',
        'date_valid',
        'status'
    ];
    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function visit() {
        return $this->belongsTo(Visit::class);
    }

    public function items() {
        return $this->hasMany(ClaimItem::class);
    }

    public function approvals() {
        return $this->hasMany(ClaimApproval::class);
    }
    

    public function documents()
    {
        return $this->hasMany(ClaimDocument::class);
    }
    

}
