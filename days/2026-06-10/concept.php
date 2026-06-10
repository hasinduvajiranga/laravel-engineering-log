// File: app/Http/Middleware/AssignControllerMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AssignControllerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Assign the authenticated user to a session variable
            session()->put('user_id', Auth::id());

            return $next($request);
        }

        // If no authentication is present, throw an exception
        throw new \Illuminate\Auth\AuthenticationException;
    }
}