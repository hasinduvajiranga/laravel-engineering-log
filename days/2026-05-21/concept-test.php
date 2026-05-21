// File: tests/Feature/UserControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function test_implicit_route_model_binding()
    {
        // Create a new user record with an ID of 1
        $user = factory(User::class)->create(['id' => 1]);

        // Make a GET request to the users.index route with the ID parameter set to 1
        $response = $this->get('/users/1');

        // Assert that the response is successful and the user data is returned
        $response->assertStatus(200);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user', $user);
    }

    public function test_implicit_route_model_binding_fails()
    {
        // Make a GET request to the users.index route with an invalid ID parameter
        $response = $this->get('/users/999');

        // Assert that the response is not successful and returns a 404 error
        $response->assertStatus(404);
    }
}