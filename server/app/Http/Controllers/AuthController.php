<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate data sent by user
        $validateUser = Validator::make($request->all(),
        [
            'name' => 'required|max:64',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|maz:64',
        ]);

        // If validation fails return 401 error with errors
        if ($validateUser->fails()) 
        {
            return response()->json([
                'message' => 'validation error',
                'erroes' => $validateUser->errors()
            ], 403);
        }

        // If validation passed create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return 201 code and auth token
        return response()->json([
            'message' => 'User created',
            'token' => $user->createToken('token')->plainTextToken
        ], 201);
    }

    public function login(Request $request) 
    {
        // Validate data sent by user
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:64',
        ]);

        // If validation fails return 401 error with errors
        if ($validateUser->fails()) 
        {
            return response()->json([
                'message' => 'Validation error',
                'erroes' => $validateUser->errors()
            ], 401);
        }

        if (!Auth::attempt($request->only(['email', 'password'])))
        {
            return response()->json([
                'message' => 'Email or password is wrong'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) 
        {
            return response()->json([
                'message' => 'Login successful',
                'token' => $user->createToken('token')->plainTextToken
            ], 201);
        }
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    public function getSelf(Request $request) {
        $userId = auth('sanctum')->user()->id;
        $user = User::where('id', $userId)->first();
        return response()->json([
            'userName' => $user->name,
        ], 200);
    }
}
