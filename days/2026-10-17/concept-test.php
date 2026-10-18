// tests/Unit/EloquentTest.php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class EloquentTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function testUserHasManyPosts()
    {
        $user = User::factory()->create();
        $post1 = Post::factory()->create(['user_id' => $user->id]);
        $post2 = Post::factory()->create(['user_id' => $user->id]);

        $this->assertEquals(2, $user->posts->count());
    }

    public function testPostHasManyComments()
    {
        $post = Post::factory()->create();
        $comment1 = Comment::factory()->create(['post_id' => $post->id]);
        $comment2 = Comment::factory()->create(['post_id' => $post->id]);

        $this->assertEquals(2, $post->comments->count());
    }

    public function testCommentHasOnePost()
    {
        $comment = Comment::factory()->create();
        $post = Post::where('id', $comment->post_id)->first();

        $this->assertEquals($comment->post_id, $post->id);
    }
}