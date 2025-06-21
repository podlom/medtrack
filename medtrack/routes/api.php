<?php

use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\TreatmentController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\ReminderController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['medtrack.cors'])->group(function () {
    Route::post('/login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    });

    Route::middleware('auth:sanctum')->get('/me', [UserController::class, 'me']);
    Route::middleware('auth:sanctum')->get('/users/me', [UserController::class, 'me']);

    Route::post('/register', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('treatments', TreatmentController::class);
        Route::apiResource('medications', MedicationController::class);
        Route::apiResource('reminders', ReminderController::class);
    });

    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
});
