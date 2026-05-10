// File: tests/Http/ControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithApplicationErrors;
use Illuminate\Foundation\Testing\WithTraversingRequests;
use Tests\TestCase;
use App\Models\PerformanceMetric;

class PerformanceControllerTest extends TestCase
{
    use WithFaker, WithApplicationErrors, WithTraversingRequests;

    public function test_index()
    {
        $this->actingAs($this->user());
        $response = $this->get('/performance');

        $this->assertEquals(200, $response->status());
        $this->assertViewHas('metrics');
    }

    public function test_optimize()
    {
        $this->actingAs($this->user());
        $response = $this->get('/optimize_performance');

        $this->assertEquals(200, $response->status());
        $this->assertViewHas('metrics');
        $this-> ExpectCacheHitForPerformanceMetrics();
    }

    private function ExpectCacheHitForPerformanceMetrics()
    {
        $this->app['cache']->expectHitFor('performance_metrics');
    }
}