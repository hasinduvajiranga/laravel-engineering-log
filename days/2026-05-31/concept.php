// Create a new macro class that will be used to create routes
namespace App\Http\Routes\Macros;

use Closure;
use Illuminate\Support\Str;

class CreateRouteMacro
{
    /**
     * Macro to create a route.
     *
     * @param string $name The name of the route.
     * @param string $uri  The URI of the route.
     * @param Closure $callback The callback function that will handle the request.
     */
    public static function createRouteMacro(string $name, string $uri, Closure $callback)
    {
        return $this->router()->group(['middleware' => 'api'], function ($router) use ($name, $uri, $callback) {
            $router->get($uri, $callback);
        });
    }
}