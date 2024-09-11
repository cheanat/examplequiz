<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== ROLE_ADMIN) {
            return response()->json([
                'statusCode' => 403,
                'message' => 'You are not allowed',
                'data' => []
            ]);
        }
        return $next($request);
    }
}
