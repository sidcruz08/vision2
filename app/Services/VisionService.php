<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Support\Facades\Log;

class VisionService
{
    public function extractText($imagePath)
    {
        try {
            $client = new ImageAnnotatorClient([
                'credentials' => config('services.google.credentials')
            ]);

            $image = file_get_contents($imagePath);
            $response = $client->documentTextDetection($image);
            $text = $response->getFullTextAnnotation()->getText();

            return $this->parseDocumentText($text);
        } catch (\Exception $e) {
            Log::error('Vision API Error: ' . $e->getMessage());
            throw new \Exception('Document processing failed');
        }
    }

    private function parseDocumentText($text)
    {
        $data = [
            'sessions' => (int) preg_match('/\b(\d+)\s+sessions?/i', $text, $matches) ? $matches[1] : 0,
            'medications' => $this->extractMedications($text),
            'dialyzers' => $this->extractDialyzers($text),
            'lab_tests' => $this->extractLabTests($text)
        ];

        return $data;
    }

    private function extractMedications($text)
    {
        $medications = [];
        $patterns = [
            'epoetin_alpha' => '/(\d+)\s*(IU|mg)\s*.*epoetin\s*alpha/i',
            'epoetin_beta' => '/(\d+)\s*(IU|mg)\s*.*epoetin\s*beta/i',
            'iron_sucrose' => '/iron\s*sucrose\s*(\d+)\s*mg/i',
            'heparin' => '/heparin\s*.*?(\d+)\s*(IU|units)/i'
        ];

        foreach ($patterns as $name => $pattern) {
            if (preg_match_all($pattern, $text, $matches)) {
                $medications[$name] = $matches[1];
            }
        }

        return $medications;
    }

    private function extractDialyzers($text)
    {
        return [
            'count' => preg_match_all('/dialyzer/i', $text, $matches),
            'type' => preg_match('/high-flux/i', $text) ? 'high-flux' : 'low-flux'
        ];
    }

    private function extractLabTests($text)
    {
        $tests = ['CBC', 'BUN', 'Creatinine', 'Potassium', 'Phosphorus', 'Calcium', 'Sodium'];
        $found = [];
        
        foreach ($tests as $test) {
            if (preg_match("/\b$test\b/i", $text)) {
                $found[] = $test;
            }
        }
        
        return $found;
    }

    public function processDocument($file)
    {
        if ($file->getMimeType() === 'application/pdf') {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->path());
            return [
                'text' => $pdf->getText(),
                'pages' => count($pdf->getPages())
            ];
        }

        $client = new ImageAnnotatorClient();
        $image = file_get_contents($file->path());
        $response = $client->documentTextDetection($image);
        
        return [
            'text' => $response->getFullTextAnnotation()->getText(),
            'pages' => 1
        ];
    }

    private function processPdf($filePath)
    {
        $parser = new Parser(); // Now uses the correct class
        $pdf = $parser->parseFile($filePath);
        // Rest of your PDF processing code
    }
}