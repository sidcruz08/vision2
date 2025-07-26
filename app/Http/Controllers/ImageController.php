<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleVisionService;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;
// use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature\Type;
use Illuminate\Support\Facades\Log;
use Google\Cloud\DocumentAI\V1\DocumentUnderstandingServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessorName;
use Google\Cloud\DocumentAI\V1\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\RawDocument;
use Google\Cloud\DocumentAI\V1\ProcessRequest;


class ImageController extends Controller
{
    protected $visionService;

    // public function __construct(GoogleVisionService $visionService)
    // {
    //     $this->visionService = $visionService;
    // }

    public function processImage(Request $request)
    {
            // Validate uploaded image or use static file
        $imageFile = $request->input('file', 'uploads/HemodialysisBenefitsAgreementForm1-scan_page-0002.jpg'); // default fallback

        $fullPath = storage_path('app/public/' . $imageFile);
        // dd(file_exists($fullPath), $fullPath);
        if (!file_exists($fullPath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        try {
            $imageAnnotator = new ImageAnnotatorClient();
            $imageData = file_get_contents($fullPath);

            // Use DOCUMENT_TEXT_DETECTION instead of TEXT_DETECTION
            $response = $imageAnnotator->documentTextDetection($imageData);
            $text = $response->getFullTextAnnotation();

            $imageAnnotator->close();

            if ($text && $text->getText()) {
                return response()->json(['detected_text' => $text->getText()]);
            } else {
                return response()->json(['message' => 'No text detected']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Vision API error', 'details' => $e->getMessage()], 500);
        }
        // $imagePath = $request->file('image')->store('uploads');
    
        // $imageFile = 'uploads/sad.png'; // Relative to storage/app/public/
        // $fullPath = storage_path('app/public/' . $imageFile);
    
        // $imageAnnotator = new ImageAnnotatorClient();
        // $imageData = file_get_contents($fullPath);
    
        // $response = $imageAnnotator->textDetection($imageData);
        // $texts = $response->getTextAnnotations();
        //         // If text is found, return the text
        //         if (count($texts) > 0) {
        //             $detectedText = $texts[0]->getDescription();
        //             return response()->json(['detected_text' => $detectedText]);
        //         } else {
        //             return response()->json(['message' => 'No text detected']);
        //         }
        // $targetWords = ['Dialysis', 'PhilHealth'];
        // $boxes = [];

        // foreach ($texts as $i => $text) {
        //     if ($i === 0) continue; // skip full text block
        //     $word = $text->getDescription();
        //     if (in_array($word, $targetWords)) {
        //         $vertices = $text->getBoundingPoly()->getVertices();
        //         $boxes[] = array_map(function ($v) {
        //             return ['x' => $v->getX(), 'y' => $v->getY()];
        //         }, iterator_to_array($vertices));
        //     }
        // }

        // $imageAnnotator->close();
        // return view('result', [
        //     'image' => asset('storage/' . $imageFile), // use defined image path here
        //     'boxes' => $boxes
        // ]);
    }

    public function analyzeStoredImage()
    {
        $imageAnnotator = new ImageAnnotatorClient();
    
        # annotate the image
        $image = file_get_contents(storage_path('app/public/uploads/sad1.png'));
    
        // Request for TEXT_DETECTION
        $response = $imageAnnotator->documentTextDetection($image);
        $text = $response->getFullTextAnnotation();

        return response()->json(['detected_text' => $text]);
        // Close the client
        $imageAnnotator->close();
        return response()->json(['detected_text' => $text]);
        // If text is found, return the text
        if (count($text) > 0) {
            $detectedText = $text[0]->getDescription();
            return response()->json(['detected_text' => $detectedText]);
        } else {
            return response()->json(['message' => 'No text detected']);
        }
    
    }

    public function validateDocument(Request $request)
    {
    // $imageAnnotator = new ImageAnnotatorClient([
    //         'credentials' => config('services.google_cloud.credentials')
    //     ]);

    //     try {
    //         $imagePath = storage_path('app/public/uploads/sad1.png');
    //         $imageContent = file_get_contents($imagePath);

    //         $response = $imageAnnotator->documentTextDetection($imageContent);
    //         $annotation = $response->getFullTextAnnotation();

    //         if (!$annotation || count($annotation->getPages()) === 0) {
    //             throw new \Exception("No text detected - please check document quality");
    //         }

    //         return $text = $annotation->getText();
    //         // $structured = $this->extractPhilHealthData($text);

    //         return response()->json([
    //             'success' => true,
    //             'structured' => $structured,
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => $e->getMessage()
    //         ], 500);
    //     } finally {
    //         $imageAnnotator->close();
    //     }
            $imageAnnotator = new ImageAnnotatorClient([
    'credentials' => config('services.google_cloud.credentials')
]);

try {
    $imagePath = storage_path('app/public/uploads/sad1.png');
    $imageContent = file_get_contents($imagePath);

    $response = $imageAnnotator->documentTextDetection($imageContent);
    $annotation = $response->getFullTextAnnotation();

    if (!$annotation || count($annotation->getPages()) === 0) {
        throw new \Exception("No text detected - please check document quality");
    }

    $text = $annotation->getText();

    // Define marks to detect
    $checkMarks = ['✓', '✔', '✔️'];
    $crossMarks = ['✗', '✘', 'X', 'x'];

    // Simple detection in full text
    $hasCheckMark = false;
    $hasCrossMark = false;

    foreach ($checkMarks as $mark) {
        if (strpos($text, $mark) !== false) {
            $hasCheckMark = true;
            break;
        }
    }

    foreach ($crossMarks as $mark) {
        if (strpos($text, $mark) !== false) {
            $hasCrossMark = true;
            break;
        }
    }

    return response()->json([
        'success' => true,
        'text' => $text,
        'has_check_mark' => $hasCheckMark,
        'has_cross_mark' => $hasCrossMark,
    ]);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'error' => $e->getMessage()
    ], 500);
} finally {
    $imageAnnotator->close();
}


    }
private function extractPhilHealthData(string $text): array
{
    $data = [];

    // Session Number
    preg_match('/HD Treatment Session No\.\s*(\d+)/i', $text, $m);
    $data['session_number'] = $m[1] ?? null;

    // Date
    preg_match('/Date \(Month\/Day\/Year\)\s*([A-Z]{3,}\s*\d{2,}\s*\d{4})/i', $text, $m);
    $data['date'] = $m[1] ?? null;

    // License Number
    preg_match('/License number\s*(\d+)/i', $text, $m);
    $data['license_number'] = $m[1] ?? null;

    // Treatment Limit
    preg_match('/covers up to (\d+) treatment sessions/i', $text, $m);
    $data['yearly_session_limit'] = $m[1] ?? null;

    // Package Rate
    preg_match('/rate for HD is (PHP [\d,]+)/i', $text, $m);
    $data['package_rate'] = $m[1] ?? null;

    // Detected check/cross marks in services
    $data['services'] = [
        'Epoetin alpha (2000 IU/0.5 mL)' => str_contains($text, '2000 IU/0.5 mL pre-filled syringe') ? '✔' : '✘',
        'Epoetin alpha (4000 IU/0.4 mL)' => str_contains($text, '4000 IU/0.4 mL pre-filled syringe') ? '✔' : '✘',
        'Epoetin alpha (10,000 IU)' => str_contains($text, '10,000 IU/mL pre-filled syringe') ? '✔' : '✘',
        'Heparin sodium 1000 IU/mL' => str_contains($text, 'Heparin sodium 1000 IU/mL, 5 mL vial') ? '✔' : '✘',
    ];

    return $data;
}


    public function testParser()
    {
        // Load from .env
        $projectId = env('DOCUMENT_AI_PROJECT_ID');
        $location = env('DOCUMENT_AI_LOCATION', 'us');
        $processorId = env('DOCUMENT_AI_PROCESSOR_ID');
        $credentialsPath = env('GOOGLE_APPLICATION_CREDENTIALS');

        // Validate credentials file
        if (!is_string($credentialsPath) || !file_exists($credentialsPath)) {
            return response()->json([
                'error' => 'Invalid or missing credentials path.',
                'path' => $credentialsPath,
            ], 500);
        }

        // File to parse (test file)
        $filePath = storage_path('app/public/uploads/sad1.png');
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found at: ' . $filePath], 404);
        }

        $mimeType = mime_content_type($filePath);
        $fileContent = file_get_contents($filePath);

        try {
            // Initialize Document AI client
            $client = new DocumentProcessorServiceClient([
                'credentials' => $credentialsPath,
            ]);

            // Prepare processor name
            $processorName = $client->processorName($projectId, $location, $processorId);

            // Prepare raw document
            $rawDocument = new RawDocument([
                'content' => $fileContent,
                'mime_type' => $mimeType,
            ]);

            // Prepare request
            $request = new ProcessRequest([
                'name' => $processorName,
                'raw_document' => $rawDocument,
            ]);

            // Process the document
            $response = $client->processDocument($request);
           return $document = $response->getDocument();

            // Extract key-value fields
            $fields = [];
            foreach ($document->getPages() as $page) {
                foreach ($page->getFormFields() as $field) {
                    $key = $field->getFieldName()?->getTextAnchor()?->getContent() ?? '';
                    $value = $field->getFieldValue()?->getTextAnchor()?->getContent() ?? '';
                    if (trim($key) !== '') {
                        $fields[trim($key)] = trim($value);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'parsed_fields' => $fields,
                'file_name' => basename($filePath),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Processing failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
