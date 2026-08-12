// tests/Features/HasManyThroughTest.php

namespace Tests\Features;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\PostComment;

class HasManyThroughTest extends TestCase
{
    public function test_user_has_many_posts()
    {
        $user = User::factory()->create();
        $post1 = Post::factory()->create(['user_id' => $user->id]);
        $post2 = Post::factory()->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->posts);

        $this->assertEquals($post1->id, $user->posts[0]->post_id);
        $this->assertEquals($post2->id, $user->posts[1]->post_id);
    }

    public function test_post_has_many_comments()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment1 = PostComment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);
        $comment2 = PostComment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $this->assertCount(2, $post->comments);

        $this->assertEquals($comment1->id, $post->comments[0]->comment_id);
        $this->assertEquals($comment2->id, $post->comments[1]->comment_id);
    }

    public function test_post_comments_belongs_to_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment1 = PostComment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $comment1->user);
    }

    public function test_user_has_many_comments()
    {
        $user = User::factory()->create();
        $post1 = Post::factory()->create(['user_id' => $user->id]);
        $post2 = Post::factory()->create(['user_id' => $user->id]);
        $comment1 = PostComment::factory()->create(['post_id' => $post1->id, 'user_id' => $user->id]);
        $comment2 = PostComment::factory()->create(['post_id' => $post2->id, 'user_id' => $user->id]);

        $this->assertCount(2, $user->comments);

        $this->assertEquals($comment1->id, $user->comments[0]->comment_id);
        $this->assertEquals($comment2->id, $user->comments[1]->comment_id);
    }

    public function test_user_comments_belongs_to_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment1 = PostComment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $this->assertInstanceOf(Post::class, $comment1->post);
    }
}