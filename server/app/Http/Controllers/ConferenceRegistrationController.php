<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationAdminEmail;
use App\Mail\RegistrationEmail;
use App\Models\ConferenceRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ConferenceRegistrationController extends Controller
{
    public function createRegistration(Request $request)
    {
        $validateRegistration = Validator::make($request->all(),
        [
            'email' => 'required|email|unique:conference_registrations',
        ]);

        if ($validateRegistration->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validateRegistration->errors()
            ], 403);
        }

        $registration = ConferenceRegistration::create([
            'email' => $request->email,
            'cancelationToken' => bin2hex(random_bytes(16)),
        ]);
        
        Mail::to($registration->email)->send(new RegistrationEmail([
            'email' => $registration->email,
            'cancelLink' => 'http://localhost:5173/register/' . $registration->cancelationToken
       ]));

       // TODO CHANGE
       Mail::to('dominik.morong@student.ukf.sk')->send(new RegistrationAdminEmail([
        'email' => $registration->email,
        ]));

        return response()->json([
            'message' => 'Registration to conference was successfull',
            'data' => $registration
        ], 201);
    }

    public function cancelRegistration($token)
    {
        $registration = ConferenceRegistration::where('cancelationToken', $token)->first();
    
        if ($registration) {
            $registration->delete();
    
            return response()->json([
                'message' => 'Registration cancelled successfully'
            ], 200);
        }
    
        return response()->json([
            'message' => 'Registration not found'
        ], 404);
    }

    public function getRegistrations()
    {
        $registrations = ConferenceRegistration::get(['email', 'id']);

        return response()->json([
            'message' => 'Registrations retrieved successfully',
            'data' => $registrations
        ], 200);
    }

}
