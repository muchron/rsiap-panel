<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('X-API-KEY');
        if (!$header || $header !== 'tJJxupMgrqvY7YaPbE2zIdH18VSyL7SM') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
