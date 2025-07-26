<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_id', 'item_description', 'item_type', 'amount', 'approved_amount'
    ];

    public function claim() {
        return $this->belongsTo(Claim::class);
    }
}
