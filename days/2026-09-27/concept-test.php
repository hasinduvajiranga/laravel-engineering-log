// File: tests/Http Tests/UserControllerTest.php

namespace Tests\Http Tests;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testIndex()
    {
        // Create some users for testing
        factory(User::class, 2)->create();

        // Get all users using raw SQL query with Eloquent
        $response = $this->get('/api/users');

        $response->assertJsonCount(2);
    }

    public function testShow()
    {
        // Create a user for testing
        $user = factory(User::class)->create();

        // Get the user by ID using raw SQL query with Eloquent
        $response = $this->get('/api/users/' . $user->id);

        $response->assertJson(['data' => $user]);
    }
}