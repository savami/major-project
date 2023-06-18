<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function create()
    {
        return Inertia::render('Jobs/Create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'photo_type' => 'required',
            'photo_contents' => 'required',
            'photo_style' => 'required',
            'text_topic' => 'required',
            'text_keywords' => 'required',
            'text_length' => 'required',
            'text_tone' => 'required',
            'text_cta' => 'required',
            'text_language' => 'required',
        ]);

        $job = new Job($validateData);
        $job->user_id = auth()->user()->id;
        $job->save();

        return redirect('/jobs/' . $job->id);
    }
}
