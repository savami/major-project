<?php

namespace App\Http\Controllers;

use App\Models\PhotoJob;
use App\Models\User;
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
                    // TODO: Remove multiple selections and add skip option to nullable questions
                }
            }
        }

        $validateData = Validator::make($data, [
            'subject' => 'required|string',
            'mood' => 'required|string',
            'orientation' => 'nullable|string',
            'elements' => 'required|string',
            'style' => 'nullable|string',
            'setting' => 'required',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ])->validate();

        dd($validateData);

        $pexelsService = new PexelsService();


        if (config('openai.enable_gpt3_enhancement')) {
            $searchQuery = $pexelsService->generateQuery([
                'subject' => $validateData['subject'],
                'mood' => $validateData['mood'],
                'elements' => $validateData['elements'],
                'style' => $validateData['style'],
                'setting' => $validateData['setting'],
            ]);
        } else {
            $searchQuery = $validateData['subject'];
        }

        $pexelsResponse = $pexelsService->searchPhotos($searchQuery, 15, 1, $validateData['orientation'], $validateData['size'], $validateData['color']);
//        $pexelsResponse = $pexelsService->searchPhotos($searchQuery);

//        dd($pexelsResponse);

        $photoJob = new PhotoJob($validateData);
        $photoJob->user_id = auth()->user()->id;
        $photoJob->pexels_response = $pexelsResponse;
        $photoJob->save();

//        return redirect('/photo-jobs/' . auth()->user()->id . '/' . $photoJob->id);
        return redirect()->route('photoJobs.show', ['userId' => auth()->user()->id, 'photoJobId' => $photoJob->id]);

    }

    public function show($userId, $photoJobId)
    {
        // Retrieve the PhotoJob by its id and return it to the view
        $photoJob = PhotoJob::where('user_id', $userId)
            ->where('id', $photoJobId)
            ->first();

        // You could also check if the username matches the username of the user who created the PhotoJob
        if (auth()->user()->id !== (int)$userId) {
            abort(404);
        }

        $pexelsResponse = $photoJob->pexels_response;


//        dd($userId, $photoJobId, $photoJob);

        return Inertia::render('PhotoJobs/PhotoJobShow', [
            'pexelsResponse' => $pexelsResponse,
        ]);
    }
}
