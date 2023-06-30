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
           $query = $this->generateQuery($query);
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

    private function generateQuery($query)
    {
        // The "engine" parameter is set to "davinci" in this example, but you can use "curie", "babbage", or "ada"
        // depending on the capability and cost you want. You can find more information about the engines
        // at https://beta.openai.com/docs/engines.
        $prompts = [
            'Translate this photo search query to a more descriptive query: "' . $query . '"',
            'Enhance this photo search query with more detail: "' . $query . '"',
            'Expand this photo search query with more specific terms: "' . $query . '"'
        ];
        $prompt = $prompts[array_rand($prompts)];

        // Make the API call
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 60
        ]);

        // Retrieve the generated text from the API response
        return $result['choices'][0]['text'];
    }
}
