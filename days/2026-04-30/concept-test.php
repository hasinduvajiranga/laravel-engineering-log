// tests/Feature/UserControllerTest.php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_index_returns_all_users()
    {
        // Create some sample users for testing
        factory(User::class, 10)->create();

        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    public function test_show_returns_user_with_posts()
    {
        // Create a sample user with posts
        $user = User::factory()->create(['posts' => factory(Post::class)->c
factory(Post::class)->count(2)]);
        $response = $this->get('/api/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['name', 'email', 'posts'
'posts']]);
    }
}