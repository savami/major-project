<?php

namespace App\Http\Controllers;

use App\Models\PhotoJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Services\PexelsService;

class PhotoJobController extends Controller
{
    public function create()
    {
        return Inertia::render('PhotoJobs/PhotoJobCreate');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        foreach ($data as $questionId => $answer) {
            if (is_array($answer)) {
                if (count($answer) === 1) {
                    $data[$questionId] = $answer[0];
                } elseif (count($answer) > 1) {
                    $data[$questionId] = "both";
                }
            }
        }

        $validateData = Validator::make($data, [
            'subject' => 'required|string',
            'mood' => 'required|string',
            'orientation' => 'required',
            'elements' => 'required|string',
            'style' => 'required',
            'setting' => 'required',
            'purpose' => 'required|string',
        ])->validate();

        $pexelsResponse = (new PexelsService())->searchPhotos($validateData['subject']);

        $photoJob = new PhotoJob($validateData);
        $photoJob->user_id = auth()->user()->id;
        $photoJob->pexels_response = $pexelsResponse;
        $photoJob->save();

        return redirect('/photo-jobs/' . auth()->user()->name . '/' . $photoJob->id);
    }

    public function show($username, $id)
    {
        // Retrieve the PhotoJob by its id and return it to the view
        $photoJob = PhotoJob::findOrFail($id);

        // You could also check if the username matches the username of the user who created the PhotoJob
        if ($photoJob->user->username !== $username) {
            abort(404);
        }

        return Inertia::render('PhotoJobs/PhotoJobShow', ['photoJob' => $photoJob]);
    }
}
