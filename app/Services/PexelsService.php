<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class PexelsService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('PEXELS_API_KEY');
        $this->baseUrl = 'https://api.pexels.com/v1/';
    }

    public function searchPhotos($query, $per_page = 15, $page = 1)
    {
        if (env('ENABLED_GPT_3_ENHANCEMENT')) {
           $prompt = "Search for photos of " . $query . " on Pexels.\n\n";
           $result = OpenAI::completions()->create([
              'model' => 'text-davinci-003',
                'prompt' => $prompt,
           ]);
           $query = $result['choices'][0]['text'];
        }

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->get($this->baseUrl . 'search', [
            'query' => $query,
            'per_page' => $per_page,
            'page' => $page,
        ]);

        if ($response->ok()) {
            return $response->json();
        } else if ($response->status() === 401) {
            throw new Exception('Invalid API key');
        } else if ($response->status() === 404) {
            throw new Exception('Not found');
        } else if ($response->status() === 429) {
            throw new Exception('API Request Limit Reached');
        } else {
            throw new Exception('Something went wrong');
        }
    }
}
