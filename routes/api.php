<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StagiaireController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\FormateurController;

// Groupe des routes d'authentification
Route::prefix('auth')->group(function () {
    // Inscription
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Connexion
    Route::post('/log-action', function (Request $request) {
        $user = $request->user();
        $action = $request->input('action');

        if ($user && in_array($user->role, ['admin','formateur','participant','stagiaire'])) {
            Log::channel($user->role)->info("{$user->name} a fait l’action : {$action}");
        } else {
            Log::channel('stack')->info("Action non classée : {$action}");
        }

        return response()->json(['status' => 'ok']);
    })->middleware('auth:sanctum'); // sécurité avec token
    
    // Routes protégées par Sanctum (nécessitent un token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('stagiaires', StagiaireController::class);
        Route::apiResource('participants', ParticipantController::class);
        Route::apiResource('formateurs', FormateurController::class);

        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::put('/auth/update-profile', [AuthController::class, 'updateProfile']);
        Route::post('/auth/update-photo', [AuthController::class, 'updatePhoto']);
    });
});