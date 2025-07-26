<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\PdfToImage\Pdf;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Support\Facades\Storage;


class DocumentController extends Controller
{
    public function showForm()
    {
        return view('upload-form');
    }

    public function process(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:20480',
        ]);

        $pdfPath = $request->file('pdf')->store('uploads', 'public');
        $fullPdfPath = storage_path('app/public/' . $pdfPath);

        $pdf = new Pdf($fullPdfPath);
        $pageCount = $pdf->getNumberOfPages();

        $imageAnnotator = new ImageAnnotatorClient();
        $results = [];

        for ($page = 1; $page <= $pageCount; $page++) {
            $imageFilename = "uploads/page_{$page}.jpg";
            $imageFullPath = storage_path("app/public/{$imageFilename}");

            $pdf->setPage($page)->saveImage($imageFullPath);

            $imageData = file_get_contents($imageFullPath);
            $response = $imageAnnotator->documentTextDetection($imageData);
            $annotation = $response->getFullTextAnnotation();

            $text = $annotation ? $annotation->getText() : '[No text found]';
            $results[] = [
                'page' => $page,
                'image' => asset("storage/{$imageFilename}"),
                'text' => $text,
            ];
        }

        $imageAnnotator->close();

        return view('ocr-results', compact('results'));
    }
}