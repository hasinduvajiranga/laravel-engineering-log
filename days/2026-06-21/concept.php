// File: app/Http/Middleware/RequestMacro.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequestMacro
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Define a macro to add the X-Macros header with the request data.
        // This can be used for logging or other purposes.
        $request->headers()->add('X-Macros', json_encode($request->all()));

        return $next($request);
    }
}