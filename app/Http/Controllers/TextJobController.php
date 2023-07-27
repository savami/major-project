<?php

namespace App\Http\Controllers;

use App\Models\TextJob;
use App\Services\GptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TextJobController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $textJobs = TextJob::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return Inertia::render('TextJobs/TextJobs', [
            'textJobs' => $textJobs,
        ]);
    }

    public function create()
    {
        return Inertia::render('TextJobs/TextJobCreate');
    }

    public function show($userId, $textJobId)
    {
        $textJob = TextJob::where('user_id', $userId)->where('id', $textJobId)->firstOrFail();

        if ($textJob->user_id !== auth()->user()->id) {
            abort(403);
        };

        $seoText = $textJob->generated_seo_text;

        return Inertia::render('TextJobs/TextJobShow', [
            'seoText' => $seoText,
            'textJob' => $textJob,
        ]);
    }

    public function store(Request $request, GptService $gptService)
    {
        $data = $request->all();

        $defaultData = [
            'name' => '',
            'subject' => '',
            'word_amount' => '',
            'text_tone' => '',
            'audience_intent' => '',
            'primary_keyword' => '',
            'secondary_keywords' => '',
//            'frequently_asked_questions' => '',
            'call_to_action' => '',
            'text_language' => '',
        ];

        $data = array_merge($defaultData, $data);

        foreach ($data as $questionId => $answer) {
            if (is_array($answer)) {
                if (count($answer) === 1) {
                    $data[$questionId] = $answer[0];
                } elseif (count($answer) === 0) {
                    $data[$questionId] = null;
                }
            }
        }

        try {
        $validateData = Validator::make($data, [
            'name' => 'required|string',
            'subject' => 'required|string',
            'word_amount' => 'required|integer',
            'text_tone' => 'required|string',
            'audience_intent' => 'required|string',
            'primary_keyword' => 'required|string',
            'secondary_keywords' => 'nullable|string',
            'call_to_action' => 'required|string',
            'text_language' => 'nullable',
            ])->validate();
        } catch (\Exception $e) {
            dd($e);
        }

        $textJob = new TextJob($validateData);
        $textJob->user_id = auth()->user()->id;

        $seoText = $gptService->generateSeoText($request->all());
        $textJob->generated_seo_text = $seoText;

        $textJob->save();

        return redirect()->route('textJobs.show', ['userId' => $textJob->user_id, 'textJobId' => $textJob->id]);
    }

    public function destroy($userId, $textJobId)
    {
        $textJob = TextJob::where('user_id', $userId)->where('id', $textJobId)->firstOrFail();

        if ($textJob->user_id !== auth()->user()->id) {
            abort(403);
        };

        $textJob->delete();

        return redirect()->route('textJobs.index')->with('success', 'Text job deleted successfully');
    }
}
