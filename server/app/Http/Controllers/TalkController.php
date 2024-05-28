<?php

namespace App\Http\Controllers;

use App\Models\Talk;
use App\Models\TimePeriod;
use Illuminate\Http\Request;

class TalkController extends Controller
{
    // TODO only allow to use time period without talk relationship
    public function getTalks()
    {
        $talks = Talk::with('timePeriod.stage', 'speaker', 'timePeriod')->get();
    
        // Add the time_period_id to each Talk
        $talks->each(function ($talk) {
            $talk->time_period_id = $talk->timePeriod->id;
        });
    
        if ($talks->isNotEmpty()) 
        {
            return response()->json([
                'data' => $talks
            ], 200);
        }
    
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    public function createTalk(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|max:1024',
            'descriptionShort' => 'required|max:128',
            'speaker_id' => 'required|exists:speakers,id',
            'time_period_id' => 'required|exists:time_periods,id',
        ]);
    
        $talk = Talk::create($validatedData);
    
        // Find the TimePeriod and set its talk_id
        $timePeriod = TimePeriod::find($validatedData['time_period_id']);
        $timePeriod->talk_id = $talk->id;
        $timePeriod->save();
    
        // Load the relationships
        $talk->load('timePeriod', 'speaker', 'timePeriod.stage');
    
        // Add the time_period_id to the returned object
        $talk->time_period_id = $talk->timePeriod->id;
    
        return response()->json([
            'message' => 'Talk created successfully',
            'data' => $talk
        ], 201);
    }

    public function deleteTalk($id)
    {
        $talk = Talk::find($id);

        if ($talk) 
        {
            $talk->delete();

            return response()->json([
                'message' => 'Talk deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Talk not found'
        ], 404);
    }

    public function updateTalk(Request $request, $id)
    {
        $validatedData = $request->validate([
            'description' => 'required|max:1024',
            'descriptionShort' => 'required|max:128',
            'speaker_id' => 'required|exists:speakers,id',
            'time_period_id' => 'required|exists:time_periods,id',
        ]);
    
        $talk = Talk::find($id);
    
        if ($talk) {
            // Remove the talk_id from the current TimePeriod
            $currentPeriod = $talk->timePeriod;
            if ($currentPeriod) {
                $currentPeriod->talk_id = null;
                $currentPeriod->save();
            }
    
            $talk->update($validatedData);
    
            // Update the relationship
            $timePeriod = TimePeriod::find($validatedData['time_period_id']);
            if ($timePeriod) {
                $timePeriod->talk_id = $talk->id;
                $timePeriod->save();
            }
    
            // Load the relationships
            $talk->load('timePeriod', 'speaker', 'timePeriod.stage');
    
            // Add the time_period_id to the returned object
            $talk->time_period_id = $talk->timePeriod->id;
    
            return response()->json([
                'message' => 'Talk updated successfully',
                'data' => $talk
            ], 200);
        }
    
        return response()->json([
            'message' => 'Talk not found'
        ], 404);
    }

    public function getTalk($id)
    {
        $talk = Talk::with('timePeriod.stage', 'speaker', 'timePeriod')->find($id);

        if ($talk) {
            // Add the time_period_id to the Talk
            $talk->time_period_id = $talk->timePeriod->id;

            return response()->json([
                'data' => $talk
            ], 200);
        }

        return response()->json([
            'message' => 'Talk not found'
        ], 404);
    }
}
