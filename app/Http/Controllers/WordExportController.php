<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class WordExportController extends Controller
{
    public function generate(Request $request)
    {
        $templatePath = resource_path('templates/sample-template.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Replace placeholders
        $templateProcessor->setValue('name', 'Juan Dela Cruz'); // or $request->input('name')

        // Save to storage
        $fileName = 'sample-template.docx';
        $savePath = storage_path("app/public/$fileName");
        $templateProcessor->saveAs($savePath);

        // Optional: download response
        return response()->download($savePath)->deleteFileAfterSend(true);
    }
}

