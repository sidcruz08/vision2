<?php

namespace App\Services;

// use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
class GoogleVisionService
{
    protected $imageAnnotator;

    public function __construct()
    {
        $this->imageAnnotator = new ImageAnnotatorClient();
    }

    public function detectText($imagePath)
    {
        $image = file_get_contents($imagePath);
        $response = $this->imageAnnotator->textDetection($image);
        $texts = $response->getTextAnnotations();

        return !empty($texts) ? $texts[0]->getDescription() : null;
    }

    public function detectLabels($imagePath)
    {
        $image = file_get_contents($imagePath);
        $response = $this->imageAnnotator->labelDetection($image);
        $labels = $response->getLabelAnnotations();

        return array_map(fn ($label) => $label->getDescription(), $labels);
    }
}
