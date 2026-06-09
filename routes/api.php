<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/health', function () {
    // Basic health check
    return response()->json(['status' => 'healthy', 'timestamp' => now()]);
});


Route::post('/legacy-login', function(Request $request) {
    try {
        if (Auth::attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ])) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->idtbl_user,
                    'name' => $user->name,
                    'username' => $user->username,
                    'tbl_user_type_idtbl_user_type' => $user->tbl_user_type_idtbl_user_type ?? null,
                    'imagepath' => $user->imagepath ?? null,
                ]
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    } catch (\Throwable $e) {
        Log::error('Legacy login error: ' . $e->getMessage(), ['exception' => $e]);
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
});
