<?php

// app/Http/Middleware/RateLimitedContestAccess.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitedContestAccess
{
    public function handle(Request $request, Closure $next, $maxAttempts = 60)
    {
        $key = 'contest-access:' . $request->ip();

        RateLimiter::tooManyAttempts($key, $maxAttempts)
            ? $this->registerAttempt($key, $maxAttempts)
            : $this->clearAttempts($key);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'error' => 'Too many attempts',
                'retry_after' => RateLimiter::availableIn($key)
            ], 429);
        }

        return $next($request);
    }

    private function registerAttempt($key, $maxAttempts)
    {
        RateLimiter::hit($key);
        
        $decayMinutes = 1;
        
        return response()->json([
            'error' => 'Too many attempts',
            'retry_after' => RateLimiter::availableIn($key)
        ], 429);
    }

    private function clearAttempts($key)
    {
        RateLimiter::clear($key);
    }
}