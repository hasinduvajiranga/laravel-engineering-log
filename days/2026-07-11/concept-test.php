// tests/Feature/UserControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_render_admin_template()
    {
        // Set up the user with admin credentials
        $user = factory(User::class)->create([
            'is_admin' => true,
        ]);

        // Request the users index route
        $response = $this->get('/users');

        // Assert that the response status code is 200
        $response->assertStatus(200);

        // Assert that the view contains the isAdmin variable
        $response->assertViewHas('isAdmin', true);
    }

    public function test_index_render_user_template()
    {
        // Set up the user without admin credentials
        $user = factory(User::class)->create([
            'is_admin' => false,
        ]);

        // Request the users index route
        $response = $this->get('/users');

        // Assert that the response status code is 200
        $response->assertStatus(200);

        // Assert that the view does not contain the isAdmin variable
        $response->assertViewHas('isAdmin', false);
    }
}