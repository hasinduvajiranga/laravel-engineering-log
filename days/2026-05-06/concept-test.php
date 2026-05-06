// File: tests/Http/ControllerTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Controllers\PerformanceController;

class PerformanceControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker, WithoutMiddleware, RefreshDatabase;

    public function test_index_returns_correct_data()
    {
        $response = $this->get(route('performance'));

        $response->assertStatus(200);
        $response->assertViewIs('performance');
        $response->assertViewHas('metrics');

        $data = json_decode($response->content(), true);

        foreach ($data as $metric) {
            $this->assertEquals('metric_name', $metric['name']);
            $this->assertEquals('expected_value', $metric['value']);
        }
    }

    public function test_index_caches_data()
    {
        // Mock the cache to return the cached data
        \Cache::rememberForever = function () {
            return ['metric1' => 'value1', 'metric2' => 'value2'];
        };

        $response = $this->get(route('performance'));

        $data = json_decode($response->content(), true);

        $this->assertEquals(['metric1' => 'value1', 'metric2' => 'value2'],
'value2'], $data);
    }
}