<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->type !== 1) {
                return response()->json(['error' => 'User is not authorized'], Response::HTTP_UNAUTHORIZED);
            }
        } else {
            return response()->json(['error' => 'User is not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
