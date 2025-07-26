<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = ['diagnosis_id', 'treatment_type', 'notes'];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }
}
