<?php

namespace App\Http\Controllers;

use App\Models\PhotoJob;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PhotoJobController extends Controller
{
    public function create()
    {
        return Inertia::render('PhotoJobs/Create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'photo_type' => 'required',
            'photo_contents' => 'required',
            'photo_format' => 'required',
        ]);

        $photoJob = new PhotoJob($validateData);
        $photoJob->user_id = auth()->user()->id;
        $photoJob->save();

        return redirect('/photo-jobs/' . $photoJob->id);
    }
}
