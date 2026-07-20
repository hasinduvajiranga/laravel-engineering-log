// tests/Feature/UserTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public function test_user_casting()
    {
        $user = User::factory()->create();

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john.doe@example.com', $user->email);

        // Test the casting of the 'posts' relationship
        $posts = $user->posts;
        $this->assertCount(1, $posts);

        foreach ($posts as $post) {
            $this->assertTrue($post->user_id === $user->id);
        }
    }

    public function test_user_casting_with_invalid_type()
    {
        $user = User::factory()->create();

        $user->name = ' invalid name ';
        $user->save();

        $this->assertEquals('invalid name', $user->fresh()->name);

        // Test the casting of the 'posts' relationship
        $posts = $user->posts;
        $this->assertCount(1, $posts);

        foreach ($posts as $post) {
            $this->assertTrue($post->user_id === $user->id);
        }
    }
}