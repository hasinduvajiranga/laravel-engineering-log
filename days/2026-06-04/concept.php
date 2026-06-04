// File: App/Http/RouteCompile.php

namespace App\Http;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Compiler;

class RouteCompiler extends Compiler
{
    /**
     * Compile the route.
     *
     * @param  array<string, \Closure>  $route
     * @return void
     */
    public function compile(array $route)
    {
        // We'll store our compiled routes in this array
        $compiledRoutes = [];

        // Iterate over each route and its handler
        foreach ($route as $method => $handler) {
            // Check if the method is already handled by a different route
            $existingMethod = null;
            foreach ($compiledRoutes as &$r) {
                if ($r['method'] === $method && $r['callable'] !== $handler) {
                    $existingMethod = $r['method'];
                    break;
                }
            }

            // If the method is already handled, we'll merge the handlers
            if ($existingMethod) {
                // Create a new class that combines both handlers
                $combinedHandler = new class($handler, $existingMethod) extends \Illuminate\Routing\{get, post, put, delete} {
                    use $existingMethod;

                    public function __invoke()
                    {
                        return call_user_func_array([$this, 'method'], [arg] + $route[$method]->argument());
                    }
                };

                // Update the existing method with our new combined handler
                foreach ($compiledRoutes as &$r) {
                    if ($r['method'] === $existingMethod) {
                        $r['callable'] = $combinedHandler;
                    }
                }
            } else {
                // Otherwise, we'll add it to our compiled routes array
                $compiledRoutes[] = [
                    'method' => $method,
                    'callable' => $handler,
                ];
            }
        }

        // Compile the routes
        Route::compile($compiledRoutes);
    }
}