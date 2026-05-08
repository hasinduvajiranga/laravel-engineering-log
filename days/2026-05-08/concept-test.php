// File: tests/Http/Controllers/PerformanceOptimizedControllerTest.php

namespace Tests\Http\Controllers;

use App\Http\Controllers\PerformanceOptimizedController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Pest\Laravel\Feature;

class PerformanceOptimizedControllerTest extends Feature
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        // Mocking the computePerformanceData method to return a cached val
value
        $this->mock(PerformanceOptimizedController::class)
            ->shouldReceive('computePerformanceData')
            ->andReturn(Cache::get('performance_data'));

        // Verifying that the view is rendered correctly with the cached da
data
        $response = $this->get('/performance-optimized');

        $response->assertViewIs('performance-optimized');
    }

    public function test_computePerformanceData()
    {
        // Clearing the cache before each test to ensure fresh data
        Artisan::call('cache:clear');

        // Verifying that the computePerformanceData method is called when 
cache is empty
        $this->mock(PerformanceOptimizedController::class)
            ->shouldReceive('computePerformanceData')
            ->once();

        // Simulating a computationally expensive task to test performance 
optimization
        $this->mock(PerformanceOptimizedController::class)
            ->shouldReceive('computePerformanceData')
            ->andReturnFrom($this->faker->randomElement(['cached_data']));
    }
}