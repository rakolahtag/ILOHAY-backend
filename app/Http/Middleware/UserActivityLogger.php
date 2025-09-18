<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserActivityLogger
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->user()) {
            $user = $request->user();
            $role = $user->role ?? 'guest';

            $message = sprintf(
                "[%s] %s (ID: %s) a accédé à %s via %s",
                ucfirst($role),
                $user->name ?? $user->email,
                $user->id,
                $request->path(),
                $request->method()
            );

            // Logger dans le fichier correspondant
            if (in_array($role, ['admin', 'formateur', 'participant', 'stagiaire'])) {
                Log::channel($role)->info($message);
            } else {
                Log::channel('stack')->info("[AUTRE] " . $message);
            }
        }

        return $response;
    }
}
