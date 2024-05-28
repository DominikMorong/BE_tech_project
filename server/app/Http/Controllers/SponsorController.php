<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SponsorController extends Controller
{
    public function getSponsors()
    {
        $sponsors = Sponsor::all();
        if ($sponsors) 
        {
            return response()->json([
                'sponsors' => $sponsors
            ], 200);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    // Should also delete the image :(
    public function deleteSponsor(int $id)
    {
        $sponsor = Sponsor::query()->find($id);

        if ($sponsor) 
        {
            $sponsor->delete();
            return response()->json(['message' => 'Sponsor deleted'], 204);
        }
        return response()->json(['message' => 'Sponsor not found'], 404);
    }

    public function updateSponsor(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'img' => 'required|max:512',
            'name' => 'required|max:64',
            'url' => 'required|max:255'
        ]);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validator->errors()
            ], 422);
        }

        $sponsor = Sponsor::query()->find($id);

        if ($sponsor)
        {
            $sponsor->name = $request->input('name');
            $sponsor->url = $request->input('url');
            $sponsor->img = $request->input('img');
            $sponsor->update();

            return response()->json([
                'message' => 'Sponsor updated correctly',
                'sponsor' => $sponsor,
            ], 201);
        }

        return response()->json(['message' => 'Sponsor not found'], 404);
    }

    public function addSponsor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imageUrl' => 'required|max:512',
            'name' => 'required|max:64',
            'url' => 'required|max:512'
        ]);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validator->errors()
            ], 403);
        }

        $sponsor = new Sponsor();
        $sponsor->img = $request->post('imageUrl');
        $sponsor->name = $request->post('name');
        $sponsor->url = $request->post('url');

        $sponsor->save();

        return response()->json([
            'message' => 'Sponsor created',
            'sponsor' => $sponsor
        ], 201);
    }
}
