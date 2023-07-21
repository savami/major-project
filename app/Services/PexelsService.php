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

    public function searchPhotos($query, $per_page = 15, $page = 1, $orientation = '', $size = '', $color = '')
    {
        $queryParams = [
            'query' => $query,
            'per_page' => $per_page,
            'page' => $page,
        ];

        if ($orientation) {
            $queryParams['orientation'] = $orientation;
        };

        if ($size) {
            $queryParams['size'] = $size;
        };

        if ($color) {
            $queryParams['color'] = $color;
        };

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

//    private function generateQuery($form)
//    {
//        // The "engine" parameter is set to "davinci" in this example, but you can use "curie", "babbage", or "ada"
//        // depending on the capability and cost you want. You can find more information about the engines
//        // at https://beta.openai.com/docs/engines.
//        $prompts = [
//            'Translate this photo search query to a more descriptive query: "' . $query . '"',
//            'Enhance this photo search query with more detail: "' . $query . '"',
//            'Expand this photo search query with more specific terms: "' . $query . '"'
//        ];
//        $prompt = $prompts[array_rand($prompts)];
//
//        $openAiApiKey = config('openai.api_key');
//        $openAiEngine = config('openai.engine');
//
//        // Make the API call
//        $response = Http::withHeaders([
//            'Authorization' => 'Bearer ' . $openAiApiKey,
//            'Content-Type' => 'application/json',
//        ])->post('https://api.openai.com/v1/engines/' . $openAiEngine . '/completions', [
//            'prompt' => $prompt,
//            'max_tokens' => 64,
//            'temperature' => 0.7,
//            'top_p' => 1,
//            'n' => 1,
//            'stream' => false,
//            'logprobs' => null,
//            'stop' => ['\n'],
//        ]);
//
//        if ($response->successful()) {
//            $result = $response->json();
//            $enhancedQuery = trim($result['choices'][0]['text']);
//            Log::info('Original Query: ' . $query . ' | Enhanced Query: ' . $enhancedQuery);
//
//            return $enhancedQuery;
//        } else {
//            Log::error('OpenAI API request failed: ' . $response->body());
//            return $query; // return the original query if the API request fails
//        }
//
//        // Retrieve the generated text from the API response
////        return $result['choices'][0]['text'];
//    }

    public function generateQuery(array $form)
    {
        // Construct the query from the form data
        $query = "";

        if (!empty($form['subject'])) {
            $query .= "The subject of the photo should be " . $form['subject'] . ". ";
        }

        if (!empty($form['mood'])) {
            $query .= "The mood should be " . $form['mood'] . ". ";
        }

        if (!empty($form['elements'])) {
            $query .= "The photo should include " . $form['elements'] . ". ";
        }

        if (!empty($form['style'])) {
            $query .= "The style of the photo should be " . $form['style'] . ". ";
        }

        if (!empty($form['setting'])) {
            $query .= "The photo should have a " . $form['setting'] . " setting. ";
        }

        // Generate the prompt for the GPT-3 API
//        $prompts = [
//            'Translate this photo search query to a more descriptive query: "' . $query . '"',
//            'Enhance this photo search query with more detail: "' . $query . '"',
//            'Expand this photo search query with more specific terms: "' . $query . '"'
//        ];
//        $prompt = $prompts[array_rand($prompts)];

        $summary = "A photo of a {$form['subject']} in a {$form['mood']} mood, with details of {$form['elements']}, in a {$form['style']} style in a {$form['setting']} setting.";

        $prompt = "Generate a very short and simplified search query that will be used to find photos on Pexels based on these preferences: " . $summary;

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
            $enhancedQuery = trim($result['choices'][0]['text']);
            Log::info('Original Query: ' . $query . ' | Enhanced Query: ' . $enhancedQuery);

            return $enhancedQuery;
        } else {
            Log::error('OpenAI API request failed: ' . $response->body());
            return $query; // return the original query if the API request fails
        }
    }

}
