// File: tests/Http/ControllerRouteConditionalsTest.php

namespace Tests\Http\Controller;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\RouteConditionalsController;
use App\Models\User;
use Illuminate\Foundation\Testing\TestableDependencies;
use Illuminate\Support\Facades\Route;

class RouteConditionalsControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase, TestableDependencies;

    protected $controller;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user with admin role for this test
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->controller = new RouteConditionalsController();
    }

    public function testRouteWithCondition()
    {
        // Send a request with the isAdmin parameter set to true
        $response = $this->postJson(route('route-with-condition'), [
            'isAdmin' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('protected-page');

        // Check if the response contains the expected data
        $data = json_decode($response->content(), true);
        $this->assertTrue($data['isAdmin']);

        // Send a request without the isAdmin parameter and verify it returns a 401 status code
        $response = $this->postJson(route('route-with-condition'));
        $response->assertStatus(401);

        // Update the request with the isAdmin parameter set to false for subsequent requests
        $response = $this->postJson(route('route-with-condition'), [
            'isAdmin' => 0,
        ]);

        // Since this is a route with condition, it would be bypassed on the next request without the isAdmin parameter
        $response = $this->postJson(route('route-with-condition'));
        $response->assertStatus(200);
    }

    public function testAdminAccessDenied()
    {
        // Create a new user without admin role for this test
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        $response = $this->postJson(route('route-with-condition'));
        $response->assertStatus(401);
    }
}