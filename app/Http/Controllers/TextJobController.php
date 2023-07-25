<?php

namespace App\Http\Controllers;

use App\Models\TextJob;
use Illuminate\Http\Request;
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

//    public function show($userId, $textJobId)
//    {
//        $textJob = TextJob::where('user_id', $userId)->where('id', $textJobId)->firstOrFail();
//
//        return Inertia::render('TextJobs/TextJobShow', [
//            'textJob' => $textJob,
//        ]);
//    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'word_amount' => 'required|integer',
            'text_tone' => 'required|in:Formal,Informal,Neutral',
            'audience_intent' => 'required|in:Informational,Commercial,Transactional',
            'primary_keyword' => 'required|string',
            'secondary_keywords' => 'nullable|json',
            'frequently_asked_questions' => 'nullable|json',
            'call_to_action' => 'required|in:buy_now,sign_up,learn_more',
            'text_language' => 'required|string',
        ]);

        $textJob = new TextJob($request->all());
        $textJob->user_id = auth()->user()->id;
        $textJob->save();

        return redirect('/text-jobs/' . $textJob->id);
    }
}
