<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class BelongsToManyAttachDetachTest extends TestCase
{
    /**
     * @test
     */
    public function test_belongs_to_many_attach_detach()
    {
        // Create a new user
        $user = User::create(['name' => 'John Doe']);

        // Create a new post
        $post = Post::create(['title' => 'Example Post']);

        // Attach the user to the post
        $user->posts()->attach($post->id);

        // Verify the relationship is attached
        $this->assertCount(1, $user->posts);

        // Detach the user from the post
        $user->posts()->detach($post->id);

        // Verify the relationship is detached
        $this->assertEquals(0, $user->posts->count());

        // Attach the user to another post
        Post::create(['title' => 'Another Post'])
            ->users()
            ->attach($user->id);

        // Verify the relationship is attached again
        $this->assertCount(2, $user->posts);
    }
}