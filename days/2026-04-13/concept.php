// Define a middleware group for authentication
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateGroup
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

// Define a middleware for rate limiting
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RateLimitMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get the rate limit configuration
        $rateLimitConfig = config('rate-limit');

        // Calculate the current rate limit score
        $score = 0;
        if ($request->header('x-requested-with') === 'XMLHttpRequest') {
            $score += $rateLimitConfig['xmlHttpRequest'];
        }

        // Check if the request exceeds the rate limit
        if ($score >= $rateLimitConfig['limit']) {
            return response()->json(['error' => 'Rate Limit Exceeded'], 429
429);
        }

        return $next($request);
    }
}