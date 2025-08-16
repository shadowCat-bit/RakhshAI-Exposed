<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthByToken {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        if (!auth()->check()) {
            $token = $request->token;
            if ($user = PersonalAccessToken::findToken($token)) {
                auth()->loginUsingId($user->tokenable_id);
            } else {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }
        }

        return $next($request);
    }
}
