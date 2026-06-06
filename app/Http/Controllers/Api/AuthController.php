<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        // Validate request input
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->load('role');

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'role_name' => $user->role->name,
            'token' => $token
        ], 200);
    }


    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout'
            ], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Token refreshed',
                'data' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh token'
            ], 500);
        }
    }
    public function me()
    {
        return response()->json([
            'success' => true,
            'data' => Auth::user()
        ]);
    }
}