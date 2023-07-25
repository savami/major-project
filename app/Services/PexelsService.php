<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PexelsService
{
    private string $pexelsApiKey;
    private string $pexelsBaseUrl;

    public function __construct()
    {
        $this->pexelsApiKey = config('pexels.api_key');
        $this->pexelsBaseUrl = 'https://api.pexels.com/v1/';
    }

    public function searchPhotos($query, $per_page, $page, $orientation = null, $size = null, $color = null)
    {
        $queryParams = [
            'query' => $query,
            'per_page' => $per_page,
            'page' => $page,
        ];


        if ($orientation) {
            $queryParams['orientation'] = strtolower($orientation);
        };

        if ($size) {
            $queryParams['size'] = strtolower($size);
        };

        if ($color) {
            $queryParams['color'] = strtolower($color);
        };

//        dd($queryParams);

        $response = Http::withHeaders([
            'Authorization' => $this->pexelsApiKey,
        ])->get($this->pexelsBaseUrl . 'search', $queryParams);

        if ($response->ok()) {
            return $response->json();
        } else if ($response->status() === 401) {
            throw new Exception('Invalid API key: ' . config('pexels.api_key'));
        } else if ($response->status() === 404) {
            throw new Exception('Not found');
        } else if ($response->status() === 429) {
            throw new Exception('API Request Limit Reached');
        } else {
            throw new Exception('Something went wrong');
        }
    }
}
