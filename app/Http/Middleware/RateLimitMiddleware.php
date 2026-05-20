<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'req_limit:' . ($request->user() ? $request->user()->id : $request->ip());

        // Limit 4 requests per second
        if (RateLimiter::tooManyAttempts($key, 4)) {
            return response('Terlalu banyak request. Harap tunggu sebentar (maksimal 4 request per detik).', 429);
        }

        // Decay time is 1 second
        RateLimiter::hit($key, 1);

        return $next($request);
    }
}
