<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\TimePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StageController extends Controller
{

    public function createStage(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'date' => 'required|date',
            'time_periods.*.start' => 'required_with:time_periods.*.end|date_format:H:i:s',
            'time_periods.*.end' => 'required_with:time_periods.*.start|date_format:H:i:s',
        ]);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 403);
        }
    
        $stage = new Stage();
        $stage->name = $request->post('name');
        $stage->date = $request->post('date');
        $stage->save();
    
        if ($request->has('time_periods')) {
            foreach ($request->input('time_periods') as $timePeriodData) {
                $stage->timePeriods()->create([
                    'start' => $timePeriodData['start'],
                    'end' => $timePeriodData['end'],
                ]);
            }
        }
    
        // Eager load the timePeriods relationship
        $stage->load('timePeriods');
    
        return response()->json([
            'message' => 'Stage created',
            'data' => $stage
        ], 201);
    }

    public function getStages(Request $request)
    {
        $filter = $request->input('filter', false);
    
        if ($filter) {
            $stages = Stage::whereHas('timePeriods', function ($query) {
                $query->whereNull('talk_id');
            })->with(['timePeriods' => function ($query) {
                $query->whereNull('talk_id');
            }])->get();
        } else {
            $stages = Stage::with('timePeriods')->get();
        }
    
        if ($stages->isNotEmpty())
        {
            return response()->json([
                'data' => $stages
            ], 200);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    public function addTimePeriod(Request $request, Stage $stage)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|date_format:H:i:s',
            'end' => 'required|date_format:H:i:s',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 403);
        }

        $timePeriod = $stage->timePeriods()->create([
            'start' => $request->input('start'),
            'end' => $request->input('end'),
        ]);

        return response()->json([
            'message' => 'TimePeriod added',
            'data' => $timePeriod
        ], 201);
    }

    public function updateTimePeriod(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'date_format:H:i:s',
            'end' => 'date_format:H:i:s',
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 403);
        }

        $timePeriod = TimePeriod::find($id);

        if (!$timePeriod) {
            return response()->json([
                'message' => 'TimePeriod not found'
            ], 404);
        }

        if ($request->has('start')) {
            $timePeriod->start = $request->input('start');
        }

        if ($request->has('end')) {
            $timePeriod->end = $request->input('end');
        }

        $timePeriod->save();

        return response()->json([
            'message' => 'TimePeriod updated',
            'data' => $timePeriod
        ], 200);
    }

    public function deleteStage($id)
    {
        $stage = Stage::find($id);

        if (!$stage) {
            return response()->json([
                'message' => 'Stage not found'
            ], 404);
        }

        $stage->delete();

        return response(null, 204);
    }

    public function updateStage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'max:64',
            'date' => 'date',
        ]);
    
        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 403);
        }
    
        $stage = Stage::find($id);
    
        if (!$stage) {
            return response()->json([
                'message' => 'Stage not found'
            ], 404);
        }
    
        if ($request->has('name')) {
            $stage->name = $request->input('name');
        }
    
        if ($request->has('date')) {
            $stage->date = $request->input('date');
        }
    
        $stage->save();
    
        // Load the timePeriods relationship
        $stage->load('timePeriods');
    
        return response()->json([
            'message' => 'Stage updated',
            'data' => $stage
        ], 200);
    }

    public function deleteTimePeriod(Request $request, $stageId, $timePeriodId)
    {
        $stage = Stage::find($stageId);

        if (!$stage) {
            return response()->json([
                'message' => 'Stage not found'
            ], 404);
        }

        $timePeriod = TimePeriod::find($timePeriodId);

        if (!$timePeriod || $timePeriod->stage_id != $stageId) {
            return response()->json([
                'message' => 'TimePeriod not found or does not belong to the specified Stage'
            ], 404);
        }

        $timePeriod->delete();

        return response()->json([
            'message' => 'TimePeriod deleted'
        ], 200);
    }
    
}
