// RemoveControllerFiltersTest.php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\RemoveControllerFilters;
use Illuminate\Foundation\Http\Middleware\RemoveControllerFilters as Middleware;
use Illuminate\Support\Facades\Route;
use Mockery;
use PHPUnit\Framework\TestCase;

class RemoveControllerFiltersTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_remove_the_controller_filter()
    {
        // Create a mock middleware instance
        $middleware = new Middleware();

        // Define the original route
        Route::get('/original', function () {
            return 'Original route';
        });

        // Apply the middleware to the route
        $route = Route::macro('removeControllerFilter', function ($handler) use ($request, $next) {
            return $handler($request);
        });
        $route->apply($middleware);

        // Assert that the original route is gone
        $this->assertNull(Route::get('/original')->getClosure());

        // Remove the middleware and assert that the route is back to its original state
        Route::macro('removeControllerFilter', function ($handler) use ($request, $next) {
            return $handler($request);
        });
        Route::get('/original')->apply($middleware);

        $this->assertNotNull(Route::get('/original')->getClosure());
    }
}