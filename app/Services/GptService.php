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
        $secondary_keywords = implode(", ", json_decode($form['secondary_keywords']));
        $audience_intent = $form['audience_intent'];
        $frequently_asked_questions = json_decode($form['frequently_asked_questions']);
        $call_to_action = $form['call_to_action'];
        $word_amount = $form['word_amount'];
        $text_tone = $form['text_tone'];
        $text_lnaguage = $form['text_language'];

        // Formulate the prompt for GPT-3
        $preset_prompt = "As an expert SEO-copywriter, how would you approach creating an SEO-optimized text using the following information? \n\n";

//        $prompt = "These are the parameters you should follow. Text subject: '{$subject}', primary keyword: '{$primary_keyword}', secondary keywords: '{$secondary_keywords}', the audience intent is '{$audience_intent}', and the call to action is '{$call_to_action}', please generate a concise, SEO-optimized text. Make sure to address these frequently asked questions: \n\n";

        $prompt = "{$preset_prompt} Given the primary keyword: '{$primary_keyword}', secondary keywords: '{$secondary_keywords}', the audience intent is '{$audience_intent}', and the call to action is '{$call_to_action}', please generate a concise, SEO-optimized text. Make sure to address these frequently asked questions: \n\n";

        foreach($frequently_asked_questions as $question){
            $prompt .= "- {$question}\n";
        }

        $prompt .= "\nThe text should be written in a '{$text_tone} tone. It should be engaging according to the audience's intent, and it should be roughly '{$word_amount}' words. Make sure to include the primary keyword at least a few times in a natural way, and the secondary keywords at least once. Make sure to think of a subtle way to introduce the call to action, somewhere near the end of the text.  The text should be written in '{$text_lnaguage}'.";

        $prompt .= "The following is an example text for reference: \n\n";
        $prompt .= "Imagine the fresh air flowing through your hair as you effortlessly glide through the city on your new [electric scooter]. Not just any [scooter], but the [latest model] of the year 2023, which has been touted as the [best electric scooter] by various critics. With its superior speed control, [longer battery life], and comfortable riding experience, it’s not hard to see why. \n\n";
        $prompt .= "Now, we understand that you may have questions like 'How long does the battery last?' or 'Is it easy to carry around?' Rest assured, the battery can last for an impressive 50 km on a single charge and yes, it is lightweight, making it easy to carry around when you need to. \n\n";
        $prompt .= "So, are you ready to revolutionize your commuting experience? Sign up for our newsletter to get the latest updates and deals on our [electric scooters]. You wouldn't want to miss it!";
        $prompt .= "\n\nNote: The words and phrases enclosed in brackets '[ ]' in the example are potential keywords that could be utilized in the text. They serve to attract the attention of search engine algorithms and can significantly enhance the SEO performance of the text. Make sure to follow this type of approach according to the example, but with your own words and phrases based on the given information you've been provided with such as the keywords, word amount, language, text tone, call to action, etc.";

        $openAiApiKey = config('openai.api_key');
        $openAiEngine = config('openai.engine');

        // Make the API call
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openAiApiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/engines/' . $openAiEngine . '/completions', [
            'prompt' => $prompt,
            'max_tokens' => $form['word_amount'] * 6, // 6 tokens per word
            'temperature' => 0.4, // Not too random, but also not too precise/predictable
            'top_p' => 1,
            'n' => 1,
            'stream' => false,
            'logprobs' => null,
            'stop' => ['\n'],
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
}
