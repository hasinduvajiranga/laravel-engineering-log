// File: tests/Feature/Admin/PerformanceOptimizationControllerTest.php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\PerformanceData;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PerformanceOptimizationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $performanceData = factory(PerformanceData::class, 100)->create();

        $response = $this->get('/admin/optimization');

        $response->assertViewIs('admin.performance-optimization.index');
        $response->assertViewHas('performanceData', $performanceData);
    }

    public function test_optimize()
    {
        $performanceData = factory(PerformanceData::class, 100)->create();

        $this->artisan('migrate');

        $response = $this->get('/admin/optimization/optimize');

        $response->assertViewIs('admin.performance-optimization.optimize');
$response->assertViewIs('admin.performance-optimization.optimize');
        
$response->assertViewHas('performanceData', $performanceData);
    }

    public function test_reset()
    {
        $performanceData = factory(PerformanceData::class, 100)->create();

        // Reset performance data
        PerformanceData::truncate();

        $response = $this->post('/admin/optimization/reset');

        $response->assertRedirect('/admin/optimization');
    }
}