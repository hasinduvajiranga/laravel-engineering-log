// tests/Database/PostFactoryTest.php

namespace Tests\Database;

use App\Database\Factories\PostFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Post;

class PostFactoryTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_factory_creates_valid_post()
    {
        $post = PostFactory::new()->create();

        $this->assertInstanceOf(Post::class, $post);
        $this->assertNotEmpty($post->title);
        $this->assertIsString($post->content);
        $this->assertIsInt($post->user_id);
    }

    public function test_factory_sets_default_user_id()
    {
        $posts = PostFactory::new()->count(5)->create();

        foreach ($posts as $post) {
            $this->assertEquals(rand(1, 10), $post->user_id);
        }
    }
}