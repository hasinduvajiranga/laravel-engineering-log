// File: app/Http/Middleware/ParameterPassingMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class ParameterPassingMiddleware
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
        // Pass the request to the next middleware in the chain
        return $next($request);
        
        // Alternatively, you can access and manipulate the request parameters here
        // For example:
        $param1 = $request->input('param1');
        $param2 = $request->input('param2');

        // Do something with the parameters...
        // ...

        // Return the response from the next middleware in the chain
        return $next($request);
    }
}