// tests/Unit Tests/UserTest.php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class UserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_user_can_be_hydrated()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);

        // Check hydration of related models
        $post = new Post();
        $post->title = 'Hello World';
        $post->content = 'This is a test post.';
        $post->user_id = 1;

        $comment = new Comment();
        $comment->content = 'Great post!';
        $comment->user_id = 1;
        $comment->post_id = 1;

        // Check hydration of related models
        $this->assertInstanceOf(User::class, $post->user);
        $this->assertInstanceOf(Post::class, $comment->post);

        // Test relationship loading
        $user->posts()->load('comments');
        foreach ($user->posts as $post) {
            foreach ($post->comments as $comment) {
                $this->assertTrue($comment->content === 'Great post!');
            }
        }
    }

    public function test_user_relationships_are_loaded_on_hydrate()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        $this->assertNotNull($user->posts());
        $this->assertNotNull($user->comments());

        // Test relationship loading
        foreach ($user->posts as $post) {
            foreach ($post->comments as $comment) {
                $this->assertTrue($comment->content === 'Great post!');
            }
        }
    }

    public function test_user_relationships_are_loaded_on_fetch()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        // Test relationship loading
        foreach ($user->posts as $post) {
            foreach ($post->comments as $comment) {
                $this->assertTrue($comment->content === 'Great post!');
            }
        }

        // Check fetch method on relationships
        $this->assertInstanceOf(User::class, User::where('id', 1)->first()->posts());
    }

    public function test_user_relationships_are_loaded_on_eagerload()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        // Test relationship loading
        foreach ($user->posts as $post) {
            foreach ($post->comments as $comment) {
                $this->assertTrue($comment->content === 'Great post!');
            }
        }

        // Check eagerload method on relationships
        $user->load('posts', 'comments');
        foreach ($user->posts as $post) {
            foreach ($post->comments as $comment) {
                $this->assertTrue($comment->content === 'Great post!');
            }
        }
    }
}