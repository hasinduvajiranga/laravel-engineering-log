// File: tests/Feature/ExampleControllerTest.php

namespace Tests\Feature;

use App\Http\Controllers\ExampleController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExampleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_route_has_correct_params()
    {
        // Assert that the route has the correct parameters
        $this->assertRouteIsDefined('example.index', ['id' => 1]);
    }

    public function test_create_route_has_correct_params()
    {
        // Assert that the route has the correct parameters
        $this->assertRouteIsDefined('example.create', ['name' => 'John Doe']);
    }

    public function test_store_route_validates_input_data()
    {
        // Validate and save route parameter data to database or any other storage
        $response = $this->post('/example/store', [
            'id' => 1,
            'name' => 'Jane Doe',
        ]);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);

        // Assert that the data was saved to database...
    }

    public function test_show_route_has_correct_params()
    {
        // Assert that the route has the correct parameters
        $this->assertRouteIsDefined('example.show', ['id' => 1]);
    }

    public function test_edit_route_has_correct_params()
    {
        // Assert that the route has the correct parameters
        $this->assertRouteIsDefined('example.edit', ['id' => 1]);
    }

    public function test_update_route_validates_input_data()
    {
        // Validate and save route parameter data to database or any other storage
        $response = $this->patch('/example/1/update', [
            'name' => 'John Doe',
        ]);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);

        // Assert that the data was saved to database...
    }

    public function test_destroy_route_has_correct_params()
    {
        // Assert that the route has the correct parameters
        $this->assertRouteIsDefined('example.destroy', ['id' => 1]);
    }
}