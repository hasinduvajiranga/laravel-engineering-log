// tests/Unit/EloquentSoftDeleteCascadingTest.php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class EloquentSoftDeleteCascadingTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testSoftDeletesUserAndItsRelatedModels()
    {
        // Create a user and delete it
        $user = User::create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $user->delete();

        // Check if the user is soft deleted
        $this->assertTrue($user->fresh()->isSoftDeleted());

        // Get the posts and comments associated with the soft deleted user
        $posts = Post::whereHas('user', function ($query) {
            $query->where('id', $user->id);
        })->get();
        $comments = Comment::whereHas(['post' => function ($query) {
            $query->where('user_id', $user->id);
        }, 'user' => function ($query) {
            $query->where('id', $user->id);
        }])->get();

        // Check if the posts and comments are also soft deleted
        $this->assertTrue($posts->first()->fresh()->isSoftDeleted());
        $this->assertTrue($comments->first()->fresh()->isSoftDeleted());

        // Get a new post that was created before the user deletion
        $newPost = Post::create(['title' => 'New Post', 'content' => 'Content']);
        $newComment = Comment::create(['content' => 'Hello, World!'], ['post_id' => $newPost->id]);

        // Check if the new post and comment are not soft deleted
        $this->assertFalse($newPost->fresh()->isSoftDeleted());
        $this->assertFalse($newComment->fresh()->isSoftDeleted());

        // Delete the new post and its associated comment
        $newPost->delete();
        $newComment->delete();

        // Check if the new post is soft deleted
        $this->assertTrue($newPost->fresh()->isSoftDeleted());
    }

    public function testSoftDeletesCommentAndItsRelatedModels()
    {
        // Create a user and create some comments
        $user = User::create(['name' => 'John Doe', 'email' => 'john@example.com']);
        Comment::factory(2)->create(['user_id' => $user->id]);

        // Delete the user
        $user->delete();

        // Check if the user is soft deleted
        $this->assertTrue($user->fresh()->isSoftDeleted());

        // Get the post and comments associated with the soft deleted user
        $post = Post::whereHas('user', function ($query) {
            $query->where('id', $user->id);
        })->first();
        $comments = Comment::whereHas(['post' => function ($query) {
            $query->where('user_id', $user->id);
        }, 'user' => function ($query) {
            $query->where('id', $user->id);
        }])->get();

        // Check if the post and comments are also soft deleted
        $this->assertTrue($post->fresh()->isSoftDeleted());
        $this->assertTrue($comments->first()->fresh()->isSoftDeleted());

        // Delete the comment that was created before the user deletion
        Comment::where('id', 1)->delete();

        // Check if the post and comments are not soft deleted
        $this->assertFalse(Post::whereHas('user', function ($query) {
            $query->where('id', $user->id);
        })->first()->fresh()->isSoftDeleted());
        $this->assertFalse(Comment::whereHas(['post' => function ($query) {
            $query->where('user_id', $user->id);
        }, 'user' => function ($query) {
            $query->where('id', $user->id);
        }])->first()->fresh()->isSoftDeleted());
    }
}