// File: tests/Unit Tests/Models/UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_many_posts()
    {
        $user = factory(User::class)->create();

        $posts = $user->posts()->get();

        $this->assertEquals(0, $posts->count());

        $post = new Post();
        $post->title = 'Test Post';
        $post->content = 'This is a test post.';
        $post->save();

        $user->posts()->create($post->toArray());

        $posts = $user->posts()->get();

        $this->assertEquals(1, $posts->count());
    }

    public function test_user_has_one_to_many_relationship()
    {
        $user = factory(User::class)->create();

        $post = new Post();
        $post->title = 'Test Post';
        $post->content = 'This is a test post.';
        $post->save();

        $user->posts()->attach($post->id);

        $this->assertEquals(1, $user->posts()->get()->count());
    }
}