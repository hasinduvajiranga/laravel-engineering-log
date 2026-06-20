// RemoveControllerFilters.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\RemoveControllerFilters as Middleware;

class RemoveControllerFilters extends Middleware
{
    /**
     * The route key to remove.
     *
     * @var string
     */
    protected $routeKey = 'controller';

    public function handle($request, Closure $next)
    {
        // Remove the controller filter
        Route::macro('removeControllerFilter', function ($handler) use ($request, $next) {
            return $handler($request);
        });

        return parent::handle($request, $next);
    }
}