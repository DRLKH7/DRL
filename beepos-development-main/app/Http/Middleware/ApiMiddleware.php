<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (method_exists($user, 'tokenCan')) {
            if ($user->tokenCan('api-access') === false) {
                return response()->json([
                    'message' => 'Forbidden.',
                ], 403);
            }
        } elseif ($request->user()?->currentAccessToken()) {
            $abilities = $request->user()->currentAccessToken()->abilities ?? [];
            if (! in_array('api-access', $abilities, true)) {
                return response()->json([
                    'message' => 'Forbidden.',
                ], 403);
            }
        }

        return $next($request);
    }
}
