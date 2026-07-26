// tests/Feature/ExampleTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class ExampleTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function test_user_has_one_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->posts()->first()->id, $post->id);
    }

    public function test_post_belongs_to_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->posts()->first()->id, $post->user_id);
    }
}