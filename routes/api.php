<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Groupe des routes d'authentification
Route::prefix('auth')->group(function () {
    // Inscription
    Route::post('/register', [AuthController::class, 'register']);
    
    // Connexion
    Route::post('/login', [AuthController::class, 'login']);

    // Routes protégées par Sanctum (nécessitent un token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Route de test pour vérifier que l’API fonctionne
Route::get('/test', function () {
    return response()->json(['message' => 'API OK ']);
});
