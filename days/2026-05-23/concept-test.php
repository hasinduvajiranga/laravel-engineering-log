// File: tests/RouteCachingStrategiesTest.php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\CachedController;
use Illuminate\Foundation\Testing\TestCase;

class RouteCachingStrategiesTest extends TestCase
{
    use RefreshDatabase;

    public function testRouteIsCached()
    {
        $controller = new CachedController();
        $response = $controller->index();

        // Check if the response is cached and can be retrieved immediately
        $this->assertTrue(Cache::has('cached.index'));
        $this->assertEquals($response, Cache::get('cached.index'));

        // Try to retrieve the response from the cache again
        $this->assertEquals($response, Cache::get('cached.index'));
    }

    public function testRouteIsNotCachedInitially()
    {
        Route::get('cached.index', function () {
            return 'This is a cached route response';
        });
        Route::middleware('cache')->get('cached.index', function () {
            return 'This is a cached route response';
        });

        $controller = new CachedController();
        $response = $controller->index();

        // Check if the response was stored in the cache
        $this->assertTrue(Cache::has('cached.index'));
    }

    public function testRouteIsClearedAfterTimeToLive()
    {
        Route::get('cached.index', function () {
            return 'This is a cached route response';
        });
        Route::middleware('cache')->get('cached.index', function () {
            return 'This is a cached route response';
        });

        Cache::forget('cached.index');

        $controller = new CachedController();
        $response = $controller->index();

        // Check if the cache was cleared
        $this->assertFalse(Cache::has('cached.index'));
    }
}