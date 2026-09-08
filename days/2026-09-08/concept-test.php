// tests/Feature/Eloquent/LazyEagerLoadingTest.php

namespace Tests\Feature\Eloquent;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\TestCase;
use App\Models\User;
use App\Models\Post;

class EloquentLazyEagerLoadingTest extends TestCase
{
    use RefreshDatabase;

    public function test_lazy_eager_loading()
    {
        // Create a user with posts
        $user = User::create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $post1 = Post::create(['title' => 'Post 1', 'content' => 'This is post 1 content']);
        $post2 = Post::create(['title' => 'Post 2', 'content' => 'This is post 2 content']);

        // Fetch user with lazy eager loading
        $userWithPosts = User::with('posts')->find($user->id);

        // Assert that only one post is fetched for the user
        $this->assertCount(1, $userWithPosts->posts);
    }

    public function test_eager_loading()
    {
        // Create a user with posts
        $user = User::create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $post1 = Post::create(['title' => 'Post 1', 'content' => 'This is post 1 content']);
        $post2 = Post::create(['title' => 'Post 2', 'content' => 'This is post 2 content']);

        // Fetch user with eager loading
        $userWithPosts = User::with('posts')->find($user->id);

        // Assert that all two posts are fetched for the user
        $this->assertCount(2, $userWithPosts->posts);
    }
}