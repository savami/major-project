<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PexelsService
{
    private string $pexelsApiKey;
    private string $pexelsBaseUrl;

    public function __construct()
    {
        $this->pexelsApiKey = config('pexels.api_key');
        $this->pexelsBaseUrl = 'https://api.pexels.com/v1/';
    }

    public function searchPhotos($query, $per_page = 15, $page = 1)
    {
        if (config('openai.enable_gpt3_enhancement')) {
           $query = $this->generateQuery($query);
        }

        $response = Http::withHeaders([
            'Authorization' => $this->pexelsApiKey,
        ])->get($this->pexelsBaseUrl . 'search', [
            'query' => $query,
            'per_page' => $per_page,
            'page' => $page,
        ]);

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

        $openAiApiKey = config('openai.api_key');
        $openAiEngine = config('openai.engine');

        // Make the API call
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openAiApiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/engines/' . $openAiEngine . '/completions', [
            'prompt' => $prompt,
            'max_tokens' => 64,
            'temperature' => 0.7,
            'top_p' => 1,
            'n' => 1,
            'stream' => false,
            'logprobs' => null,
            'stop' => ['\n'],
        ]);

        if ($response->successful()) {
            $result = $response->json();
            return trim($result['choices'][0]['text']);
        } else {
            Log::error('OpenAI API request failed: ' . $response->body());
            return $query; // return the original query if the API request fails
        }

        // Retrieve the generated text from the API response
//        return $result['choices'][0]['text'];
    }
}
