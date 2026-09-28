// File: tests/Unit/Models/UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_many_posts()
    {
        // Create a new user and post
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Verify that the post is associated with the user
        $this->assertTrue($user->posts()->first()->id === $post->id);
    }

    public function test_user_has_many_posts_with_query_binding()
    {
        // Create a new user and multiple posts
        User::factory(2)->create();
        Post::factory(3)->create(['user_id' => 1]);

        // Use Eloquent query binding to get the users with their posts
        $usersWithPosts = User::with('posts')->get();

        // Verify that each user has a post associated with it
        foreach ($usersWithPosts as $user) {
            $this->assertGreaterThan(0, count($user->posts));
        }
    }

    public function test_user_has_one_belongs_to_post()
    {
        // Create a new user and post
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Verify that the user is associated with the post
        $this->assertTrue($post->user()->id === $user->id);
    }

    public function test_user_has_one_belongs_to_post_with_query_binding()
    {
        // Create a new user and multiple posts
        User::factory(2)->create();
        Post::factory(3)->create(['user_id' => 1]);

        // Use Eloquent query binding to get the users with their associated post
        $usersWithPost = User::with('user')->get();

        // Verify that each user has a corresponding post
        foreach ($usersWithPost as $user) {
            $this->assertNotNull($user->user);
        }
    }
}