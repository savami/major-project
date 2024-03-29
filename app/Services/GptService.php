<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GptService
{
    public function generateSeoText(array $form)
    {
        // Prepare the form data for the prompt
        $subject = $form['subject'];
        $primary_keyword = $form['primary_keyword'];
        $secondary_keywords = $form['secondary_keywords'];
        $audience_intent = $form['audience_intent'][0];
//        $frequently_asked_questions = json_decode($form['frequently_asked_questions']);
        $call_to_action = $form['call_to_action'][0];
        $word_amount = $form['word_amount'];
        $text_tone = $form['text_tone'][0];
        $text_language = $form['text_language'];

        $preset_prompt = "As an expert SEO-copywriter, your task is to generate high-quality, SEO-optimized text based on the provided details by the user such as subject, primary and secondary keywords, audience intent, call to action, tone, and language. Ensure the text is tailored to the audience's needs and optimized for search engines, using the keywords in a natural and effective manner. Make sure to add catchy titles and subheadings to grab the reader's attention, and to break the text into paragraphs. Do NOT use the primary keyword too often, as this negatively impacts the SEO rating. \n\n";

        $prompt = "Write a {$word_amount}-word text about {$subject}. The primary keyword is: '{$primary_keyword}', and the secondary keywords are: '{$secondary_keywords}'. The audience intent is {$audience_intent} and the text should target the '{$call_to_action}' call to action. Please use a {$text_tone} tone. \n\n";

        if ($text_language !== "") {
            $prompt .= "The text should be written in English.\n\n";
        } else {
            $prompt .= "The text should be written in {$text_language}.\n\n";
        }

        $openAiApiKey = config('openai.api_key');
        $openAiEngine = config('openai.engine');


//        Make the API call (for legacy GPT-3 models such as 'text-davinci-003')
        if ($openAiEngine === 'text-davinci-003') {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/engines/' . $openAiEngine . '/completions', [
                'prompt' => $prompt,
                'max_tokens' => 3750, // 3750 tokens is roughly 500 words
                'temperature' => 0.4, // Not too random, but also not too precise/predictable
                'top_p' => 1,
                'n' => 1,
                'stream' => false,
                'logprobs' => null,
                'stop' => ['\n'],
                'presence_penalty' => 0, // Penalizes words/sentences that are not present in the prompt
                'frequency_penalty' => 1, // Penalizes words/sentences that are repeated too often
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $seo_text = trim($result['choices'][0]['text']);

                Log::info('Prompt: ' . $prompt . ' | Generated SEO Text: ' . $seo_text);

                return $seo_text;
            } else {
                Log::error('OpenAI API request failed: ' . $response->body());
                return null; // return null if the API request fails
            }
        }

        // Make the API call (for GPT-3.5 models such as 'gpt-3.5-turbo')
        if ($openAiEngine === 'gpt-3.5-turbo') {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $openAiEngine,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $preset_prompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 3750, // Maximum amount of tokens per request for the GPT-3.5 models minus the amount of messages (4097 - 347 = 3750)
                'temperature' => 0.5, // Not too random, but also not too precise/predictable
                'presence_penalty' => 0.1, // Values from -2 to 2, penalizes words/sentences that are not present in the prompt
                'frequency_penalty' => 1.2, // Values from -2 to 2, penalizes words/sentences that are repeated too often
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $seo_text = trim($result['choices'][0]['message']['content']);

                Log::info('Prompt: ' . $prompt . ' | Generated SEO Text: ' . $seo_text);

                return $seo_text;
            } else {
                Log::error('OpenAI API request failed: ' . $response->body());
                return null; // return null if the API request fails
            }
        }

        // Make the API call (for GPT-3.5 models such as 'gpt-3.5-turbo')
        if ($openAiEngine === 'gpt-3.5-turbo-16k') {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $openAiEngine,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $preset_prompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 15000, // Maximum amount of tokens per request for the GPT-3.5 models minus the amount of messages (4097 - 347 = 3750)
                'temperature' => 0.5, // Not too random, but also not too precise/predictable
                'presence_penalty' => 0.1, // Values from -2 to 2, penalizes words/sentences that are not present in the prompt
                'frequency_penalty' => 1.2, // Values from -2 to 2, penalizes words/sentences that are repeated too often
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $seo_text = trim($result['choices'][0]['message']['content']);

                Log::info('Prompt: ' . $prompt . ' | Generated SEO Text: ' . $seo_text);

                return $seo_text;
            } else {
                Log::error('OpenAI API request failed: ' . $response->body());
                return null; // return null if the API request fails
            }
        }
    }

    // generateQuery() is used to generate a more descriptive search query from the form data using OpenAI's GPT-3 API with the text-davinci-003 model.
    // Configuration can be found in config/openai.php, which all points to the .env file.
    public function generatePhotoSearchQuery(array $form)
    {
        // Construct the query from the form data
        $query = "";

        // If the user has selected a subject, add it to the query
        if (!empty($form['subject'])) {
            $query .= "The subject of the photo should be " . $form['subject'] . ". ";
        }

//        if (!empty($form['mood'])) {
//            $query .= "It should convey a " . $form['mood'] . " mood. ";
//        }

        // If the user has selected elements, add them to the query
        if (!empty($form['elements'])) {
            $query .= "It should include " . $form['elements'] . ". ";
        }

        // If the user has selected a style, add it to the query
        if (!empty($form['style'])) {
            if ($form['style'] === "Monochrome") {
                $query .= "It should be taken in a  " . $form['style'] . " style. ";
            } else {
                // If user has selected Regular, add nothing to the query
                $query .= "";
            }
        }

//        if (!empty($form['setting'])) {
//            $query .= "The setting should be " . $form['setting'] . " setting. ";
//        }

        $summary = "A photo of a {$form['subject']}, with details of {$form['elements']}, taken in a {$form['style']} style.";

        $prompt = "Based on the following requirements: " . $query . "Please generate a concise search query in natural language to find photos on Pexels. The query should not include the words 'subject', 'mood', 'elements', 'style', or 'setting', and should be less than 10 words. For example you receive: 'The subject of the photo should be a happy woman. It should include a bicycle.', and from that you generate: 'happy woman bicycle' for the search query. Do NOT add quotation marks around your query.";

        $openAiApiKey = config('openai.api_key');
        $openAiEngine = config('openai.engine');

        // Make the API call
        if ($openAiEngine === 'text-davinci-003') {
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

                // Logging for ease-of-use while testing the prompts/queries/outputs
                Log::info('Original Query: ' . $query . ' | Summary: ' . $summary . ' | Enhanced Query: ' . $enhancedQuery);

                return $enhancedQuery;
            } else {
                Log::error('OpenAI API request failed: ' . $response->body());
                return $query; // return the original query if the API request fails
            }
        }

        // Make the API call (for GPT-3.5 models such as 'gpt-3.5-turbo')
        if ($openAiEngine === 'gpt-3.5-turbo' || $openAiEngine === 'gpt-3.5-turbo-16k') {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $openAiApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $openAiEngine,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "As an expert in search querying, your task is to create concise, natural language search queries for finding specific photos on Pexels. Your queries should not include the words 'subject', 'mood', 'elements', 'style', 'photo', 'image' or 'setting', and should be less than 10 words. Do NOT add quotation marks around your query."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Generate a search query for a photo with the following requirements: " . $query
                    ]
                ],
                'max_tokens' => 64,
                'temperature' => 0.4, // Not too random, but also not too precise/predictable
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $enhancedQuery = trim($result['choices'][0]['message']['content']);

                // Logging for ease-of-use while testing the prompts/queries/outputs
                Log::info('Original Query: ' . $query . ' | Enhanced Query: ' . $enhancedQuery);

                return $enhancedQuery;
            } else {
                Log::error('OpenAI API request failed: ' . $response->body());
                return $query; // return the original query if the API request fails
            }
        }
    }
}
