use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsersWithPosts()
    {
        // Create some sample data for testing
        $user1 = User::create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $post1 = Post::create(['title' => 'Sample Post 1']);
        $post2 = Post::create(['title' => 'Sample Post 2']);

        // Retrieve users with their posts
        $usersWithPosts = User::usersWithPosts();

        // Assert the expected results are returned
        $this->assertCount(3, $usersWithPosts);
        $user1->posts()->each(function ($post) use ($post) {
            $this->assertTrue($post->id === $post1->id || $post->id === $post2->id);
        });
    }
}