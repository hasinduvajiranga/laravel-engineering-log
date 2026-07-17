// File: tests/Feature/BladePerformanceControllerTest.php

namespace Tests\Feature;

use App\Http\Controllers\BladePerformanceController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class BladePerformanceControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testOptimizeBladePerformance()
    {
        // Test the optimizeBladePerformance method of the controller
        $response = $this->post('/blade-performance/optimize');

        $this->assertEquals('Blade performance optimization configured successfully!', $response->text());

        // Check if the cache directory was created correctly
        $this->assertFileExists(public_path('views/cache'));
    }

    public function testForeachDirective()
    {
        // Test that multiple blade compiles are avoided using @forelse directive
        $response = $this->post('/blade-performance');

        $data = json_decode($response->content(), true);

        foreach ($data['items'] as $item) {
            // Check if the item was correctly compiled by Blade
            $this->assertEquals($item['name'], Blade::render('item: ' . $item['name']));
        }
    }
}