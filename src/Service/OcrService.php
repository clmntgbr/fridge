<?php

namespace App\Service;

class OcrService
{
    const MAX_IMG_SIZE = 1024;
    const ENDPOINT_API = 'https://api.ocr.space/parse/imageurl?apikey=%s&url=%s&language=fre&isOverlayRequired=true';
    const REGEX = '/[0-9]?[0-9]?1[0-9]?[0-9]?1[0-9]?[0-9]?[0-9]?[0-9]?/';

    private $imageUrl = 'https://i.ibb.co/xJpX57V/IMG-5151-1.jpg';
    private array $response = [];


    public function __construct(
        private string $ocrApiKey
    ) {
    }

    public function resize(): self
    {
        return $this;
    }

    public function recognize(): self
    {
        $url = sprintf(self::ENDPOINT_API, $this->ocrApiKey, $this->imageUrl);
        $response = file_get_contents($url);
        $response = json_decode($response, true);

        if (in_array($response['OCRExitCode'], [3, 4])) {
            return $this;
        }

        $this->response = $response;

        return $this;
    }

    public function find(): ?string
    {
        if (!isset($this->response['ParsedResults'][0]['TextOverlay']['Lines'])) {
            return null;
        }

        foreach ($this->response['ParsedResults'][0]['TextOverlay']['Lines'] as $line) {
            if (1 === preg_match(self::REGEX, $line['LineText'], $matches)) {
                return $this->getDate($matches);
            }
        }

        return null;
    }

    private function getDate(array $matches): ?string
    {
        if (empty($matches)) {
            return null;
        }

        $date = \DateTime::createFromFormat('d1m1Y', $matches[0]);

        if (false === $date) {
            return null;
        }

        return $date->format('d/m/Y');
    }
}