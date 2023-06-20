<?php

namespace App\Http\Controllers;

use App\Models\TextJob;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TextJobController extends Controller
{
    public function create()
    {
        return Inertia::render('TextJobs/Create');
    }

    public function store()
    {
        $validateData = request()->validate([
            'text_topic' => 'required',
            'text_keywords' => 'required',
            'text_length' => 'required',
            'text_tone' => 'required',
            'text_cta' => 'required',
            'text_language' => 'required',
        ]);

        $textJob = new TextJob($validateData);
        $textJob->user_id = auth()->user()->id;
        $textJob->save();

        return redirect('/text-jobs/' . $textJob->id);
    }
}
