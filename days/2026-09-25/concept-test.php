// tests/ModelTest.php

namespace Tests\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTestTransaction;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use DatabaseMigrations, DatabaseTestTransaction;

    public function test_user_has_one_post()
    {
        $user = User::factory()->create();

        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->expectThat(function ($user) {
            return $user->posts()->contains($post);
        });
    }

    public function test_user_has_one_profile_picture()
    {
        $user = User::factory()->create();

        ProfilePicture::factory()->create(['user_id' => $user->id]);

        $this->expectThat(function ($user) {
            return $user->profilePictures()->contains(1);
        });
    }

    public function test_post_belongs_to_user()
    {
        $post = Post::factory()->create();

        $this->expectThat(function ($post) {
            return $post->user()->id === 1;
        });
    }
}