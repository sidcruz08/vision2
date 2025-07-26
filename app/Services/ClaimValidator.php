<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ClaimValidator
{
    public function validate(array $data)
    {
        $rules = [
            'sessions' => 'required|integer|max:' . config('claim_rules.max_sessions'),
            'medications.epoetin_alpha' => 'array|max:3',
            'medications.epoetin_beta' => 'array|max:2',
            'medications.iron_sucrose' => 'array|max:10',
            'dialyzers.count' => 'integer|max:' . config('claim_rules.dialyzer_rules.max_units'),
            'lab_tests' => 'array|max:8'
        ];

        return Validator::make($data, $rules, [
            'sessions.max' => 'Exceeded maximum allowed sessions (150/year)',
            'dialyzers.count.max' => 'Exceeded maximum dialyzers (32/year)'
        ]);
    }
}