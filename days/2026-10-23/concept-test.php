// tests/Feature/UserTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\MutationAttribute;
use Laravel\Passport\MutationAttributeTrait;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        // Mocking Eloquent's save method to prevent database calls
        $this->mock(User::class, function ($Mock) use ($user) {
            $Mock->shouldReceive('create')->with($user->toArray())->andReturnSelf();
        });

        $response = $this->post('/users', $user->toArray());

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function test_user_can_have_posts()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        // Mocking Eloquent's save method to prevent database calls
        $this->mock(User::class, function ($Mock) use ($user) {
            $Mock->shouldReceive('create')->with($user->toArray())->andReturnSelf();
        });

        $post = new Post();
        $post->title = 'Example Post';
        $post->content = 'This is an example post.';

        // Mocking Eloquent's save method to prevent database calls
        $this->mock(Post::class, function ($Mock) use ($post) {
            $Mock->shouldReceive('create')->with($post->toArray())->andReturnSelf();
        });

        $user->posts()->save($post);

        $response = $this->get('/users/' . $user->id . '/posts');

        $this->assertEquals(200, $response->getStatusCode());
    }
}