<?php

namespace App\Services;

use Carbon\Carbon;

class DateValidator
{
    public function extractDates($text)
    {
        $dates = [];
        preg_match_all('/\b(\d{4}[-\/]\d{2}[-\/]\d{2})\b|\b(\d{2}[-\/]\d{2}[-\/]\d{4})\b/', $text, $matches);
        
        foreach ($matches[0] as $dateString) {
            try {
                $dates[] = Carbon::parse($dateString)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }
        return array_unique($dates);
    }

    public function validateConsistency($dates)
    {
        return $dates->unique()->count() === 1 && $dates->isNotEmpty();
    }
}