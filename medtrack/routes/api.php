<?php

use App\Http\Controllers\Api\TreatmentController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\ReminderController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/users/me', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('treatments', TreatmentController::class);
    Route::apiResource('medications', MedicationController::class);
    Route::apiResource('reminders', ReminderController::class);
});
