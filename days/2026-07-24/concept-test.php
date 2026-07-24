// tests/Unit/EloquentRelationshipEagerLoadingTest.php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrationsTestCase;

class EloquentRelationshipEagerLoadingTest extends DatabaseMigrationsTestCase
{
    public function test_eager_load_user_with_related_posts()
    {
        // Create a user with 2 posts
        $user = User::factory()->create(['posts_count' => 2]);
        $post1 = Post::factory()->create(['user_id' => $user->id]);
        $post2 = Post::factory()->create(['user_id' => $user->id]);

        // Use eager loading to retrieve user with related posts
        $userWithPosts = User::with('posts')->find($user->id);

        // Assert that 2 posts are loaded for the user
        self::assertEquals(2, count($userWithPosts->posts));

        // Assert that each post has a user and comments
        foreach ($userWithPosts->posts as $post) {
            self::assertNotNull($post->user);
            self::assertEquals(1, $post->comments()->count());
        }
    }

    public function test_eager_load_user_with_related_comments()
    {
        // Create a user with 2 posts and 4 comments
        $user = User::factory()->create(['posts_count' => 2]);
        Post::factory()->create(['user_id' => $user->id]);
        Comment::factory(4)->create(['post_id' => $user->posts[0]->id]);

        // Use eager loading to retrieve user with related comments
        $userWithComments = User::with('comments')->find($user->id);

        // Assert that 2 posts are loaded for the user
        self::assertEquals(1, count($userWithComments->posts));

        // Assert that each post has a user and one comment
        foreach ($userWithComments->posts as $post) {
            self::assertNotNull($post->user);
            self::assertEquals(1, $post->comments()->count());
        }
    }

    public function test_eager_load_user_with_related_posts_and_comments()
    {
        // Create a user with 2 posts and 4 comments
        $user = User::factory()->create(['posts_count' => 2]);
        Post::factory()->create(['user_id' => $user->id]);
        Comment::factory(4)->create(['post_id' => $user->posts[0]->id]);

        // Use eager loading to retrieve user with related posts and comments
        $userWithPostsAndComments = User::with('posts', 'comments')->find($user->id);

        // Assert that 2 posts are loaded for the user
        self::assertEquals(1, count($userWithPostsAndComments->posts));

        // Assert that each post has a user and comments
        foreach ($userWithPostsAndComments->posts as $post) {
            self::assertNotNull($post->user);
            self::assertEquals(1, $post->comments()->count());
        }

        // Assert that 4 comments are loaded for the user
        self::assertEquals(4, count($userWithPostsAndComments->comments));
    }
}