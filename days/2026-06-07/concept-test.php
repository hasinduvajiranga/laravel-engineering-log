// tests/Feature/RouteTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function test_index_route()
    {
        $this->actingAs(\Auth::null());
        
        // Visit the index route and verify that it returns a view with the name parameter
        $response = $this->get(route('test.index'));
        $response->assertViewIs('test.index');
        $response->assertSee($this->faker()->name);
    }

    public function test_show_route()
    {
        // Visit the show route and verify that it returns a view with the name and ID parameters
        $this->actingAs(\Auth::null());
        
        $response = $this->get(route('test.show', ['id' => 1]));
        $response->assertViewIs('test.show');
        $response->assertSee($this->faker()->name);
        $response->assertSee(1);
    }
}