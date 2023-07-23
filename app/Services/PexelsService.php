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

    public function searchPhotos($query, $per_page = 80, $page = 1, $orientation = null, $size = null, $color = null)
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

    // generateQuery() is used to generate a more descriptive search query from the form data using OpenAI's GPT-3 API with the text-davinci-003 model.
    // Configuration can be found in config/openai.php, which all points to the .env file.
    public function generateQuery(array $form)
    {
        // Construct the query from the form data
        $query = "";

        //
        if (!empty($form['subject'])) {
            $query .= "The subject of the photo should be " . $form['subject'] . ". ";
        }

//        if (!empty($form['mood'])) {
//            $query .= "It should convey a " . $form['mood'] . " mood. ";
//        }

        if (!empty($form['elements'])) {
            $query .= "It should include " . $form['elements'] . ". ";
        }

//        if (!empty($form['style'])) {
//            $query .= "It should be taken in a  " . $form['style'] . " style. ";
//        }

//        if (!empty($form['setting'])) {
//            $query .= "The setting should be " . $form['setting'] . " setting. ";
//        }

//        $summary = "A photo of a {$form['subject']} in a {$form['mood']} mood, with details of {$form['elements']}, in a {$form['style']} style in a {$form['setting']} setting.";

        $summary = "A photo of a {$form['subject']}, with details of {$form['elements']}";

//        $prompt = "Generate a very short and simplified, but natural language search query seperated by commas that will be used to find photos on Pexels based on these preferences: " . $summary . ". " . "Do not include the words 'subject', 'mood', 'elements', 'style', or 'setting' in your query. " . "The query should be no more than 10 words long and should be in a STRING format with single quotes (''). " . "For example: 'Happy woman paris, louvre, detailed, vintage'";

        $prompt = "Based on the following requirements: " . $query . "Please generate a concise search query in natural language to find photos on Pexels. The query should not include the words 'subject', 'mood', 'elements', 'style', or 'setting', and should be less than 10 words. For example you receive: 'The subject of the photo should be a happy woman. It should include a bicycle.', and from that you generate: 'happy woman bicycle' for the search query.";

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
            Log::info('Original Query: ' . $query . ' | Summary: ' . $summary . ' | Enhanced Query: ' . $enhancedQuery);

            return $enhancedQuery;
        } else {
            Log::error('OpenAI API request failed: ' . $response->body());
            return $query; // return the original query if the API request fails
        }
    }

}
