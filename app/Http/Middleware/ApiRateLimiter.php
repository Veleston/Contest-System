<?php

// app/Http/Middleware/ApiRateLimiter.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ApiRateLimiter
{
    public function handle(Request $request, Closure $next, $limitName)
    {
        $key = $this->resolveRequestSignature($request, $limitName);

        if (RateLimiter::tooManyAttempts($key, $this->getMaxAttempts($limitName))) {
            $retryAfter = RateLimiter::availableIn($key);
            return response()->json([
                'error' => 'Too many attempts',
                'retry_after' => $retryAfter,
            ], 429);
        }

        RateLimiter::hit($key);

        return $next($request);
    }

    private function resolveRequestSignature(Request $request, $limitName)
    {
        return $limitName . ':' . $request->ip();
    }

    private function getMaxAttempts($limitName)
    {
        $limits = config('rate_limiter');
        return $limits[$limitName]['max_attempts'] ?? 60;
    }
}
