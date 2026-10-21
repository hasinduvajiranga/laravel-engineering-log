// tests/Feature/UserTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Laravel Sanctum;
use Pest\Laravel\Pest;
use Pest\Laravel\Tests\WithPest;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithPest;

    public function testCreateUser()
    {
        $user = factory(User::class)->create();

        $this->assertNotNull($user->id);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertEquals('testpassword', $user->password);

        // Test API endpoint for user
        $response = $this->postJson(route('users.store'), ['name' => 'Jane Doe', 'email' => 'jane.doe@example.com']);
        $response->assertStatus(201);
    }

    public function testGetUser()
    {
        $user = factory(User::class)->create();

        // Test API endpoint for user
        $response = $this->getJson(route('users.show', 1));
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testGetUserPosts()
    {
        $user = factory(User::class)->create();

        // Create a post for the user
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Test API endpoint for user's posts
        $response = $this->getJson(route('users.show', 1), ['with' => 'posts']);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'posts' => [
                [
                    'title' => $post->title,
                    'content' => $post->content,
                ],
            ],
        ]);
    }
}