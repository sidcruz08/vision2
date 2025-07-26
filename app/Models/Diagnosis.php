<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = ['visit_id', 'diagnosis_code', 'description'];

    public function visit() {
        return $this->belongsTo(Visit::class);
    }
}
