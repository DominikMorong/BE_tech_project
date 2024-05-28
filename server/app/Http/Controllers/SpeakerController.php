<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeakerController extends Controller
{
    public function getSpeakers(Request $request)
    {
        $speakers = Speaker::all();
        if ($speakers) {
            return response()->json([
                'speakers' => $speakers
            ], 200);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    public function addSpeakder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imgUrl' => 'required|max:512',
            'firstName' => 'required|max:64',
            'lastName' => 'required|max:64',
            'description' => 'required|max:1024',
            'descriptionShort' => 'required|max:255',
            'xFormerlyKnownAsTwitterProfile' => 'required|max:512',
            'facebookProfile' => 'required|max:512',
            'personalPage' => 'required|max:512',
        ]);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validator->errors()
            ], 403);
        }

        $speaker = new Speaker();
        $speaker->imgUrl = $request->post('imgUrl');
        $speaker->firstName = $request->post('firstName');
        $speaker->lastName = $request->post('lastName');
        $speaker->description = $request->post('description');
        $speaker->descriptionShort = $request->post('descriptionShort');
        $speaker->xFormerlyKnownAsTwitterProfile = $request->post('xFormerlyKnownAsTwitterProfile');
        $speaker->facebookProfile = $request->post('facebookProfile');
        $speaker->personalPage = $request->post('personalPage');

        $speaker->save();

        return response()->json([
            'message' => 'Speaker created',
            'speaker' => $speaker
        ], 201);
    }

    public function deleteSpeaker(int $id) 
    {
        $speaker = Speaker::query()->find($id);

        if ($speaker) 
        {
            $speaker->delete();
            return response()->json(['message' => 'Speaker deleted'], 204);
        }
        return response()->json(['message' => 'Speaker not found'], 404);

    }

    public function updateSpeaker(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'imgUrl' => 'required|max:512',
            'firstName' => 'required|max:64',
            'lastName' => 'required|max:64',
            'description' => 'required|max:1024',
            'descriptionShort' => 'required|max:255',
            'xFormerlyKnownAsTwitterProfile' => 'required|max:512',
            'facebookProfile' => 'required|max:512',
            'personalPage' => 'required|max:512',
        ]);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validator->errors()
            ], 422);
        }

        $speaker = Speaker::query()->find($id);


        if ($speaker)
        {
            $speaker->imgUrl = $request->post('imgUrl');
            $speaker->firstName = $request->post('firstName');
            $speaker->lastName = $request->post('lastName');
            $speaker->description = $request->post('description');
            $speaker->descriptionShort = $request->post('descriptionShort');
            $speaker->xFormerlyKnownAsTwitterProfile = $request->post('xFormerlyKnownAsTwitterProfile');
            $speaker->facebookProfile = $request->post('facebookProfile');
            $speaker->personalPage = $request->post('personalPage');
            $speaker->update();

            return response()->json([
                'message' => 'Speaker updated correctly',
                'speaker' => $speaker,
            ], 201);
        }

        return response()->json(['message' => 'Page not found'], 404);

    }
}
