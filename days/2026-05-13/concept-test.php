// File: tests/Http/ControllerTest.php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Http\Controllers\PerformanceController;

class PerformanceControllerTest extends TestCase
{
    use WithFaker, WithoutMiddleware;

    protected $controller = new PerformanceController();

    public function testIndexRoute()
    {
        // Test that the index route returns a cached response
        $response = $this->get(route('performance'));
        $response->assertViewIs('performance');
        $response->assertSessionHasNoCache();
        
        // Check if the data is cached for 1 minute
        $this->assertEquals($this->controller->cachedData, Cache::store()->
Cache::store()->get('highTrafficData'));
    }

    public function testOptimizeRoutes()
    {
        // Test that the optimize routes method clears the cache and update
updates the route cache
        $this->controller->optimizeRoutes();
        
        // Verify that the route cache has been updated
        Route::clearCache();
        $response = $this->get(route('performance'));
        $response->assertViewIs('performance');
    }
}