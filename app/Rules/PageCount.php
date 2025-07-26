<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Smalot\PdfParser\Parser;

class PageCount implements Rule
{
    public function passes($attribute, $value)
    {
        $totalPages = 0;
        foreach ($value as $file) {
            if ($file->getMimeType() === 'application/pdf') {
                $parser = new Parser();
                $pdf = $parser->parseFile($file->path());
                $totalPages += count($pdf->getPages());
            } else {
                $totalPages += 1;
            }
        }
        return $totalPages === 2;
    }

    public function message()
    {
        return 'Each claim must contain exactly 2 pages across all documents.';
    }
}