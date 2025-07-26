<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimDocument extends Model
{
    use HasFactory;

    protected $fillable = ['claim_id', 'file_path'];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
}
