// tests/PostTest.php

namespace Tests\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetPosts()
    {
        // Create some posts
        $posts = factory(Post::class, 5)->create();

        // Retrieve cached results
        $cachedPosts = Post::getPosts();

        // Verify that the expected number of posts is returned
        self::assertCount(5, $cachedPosts);

        // Test caching functionality by deleting cache and retrieving again
        Cache::forget('posts');
        $retrievedPosts = Post::getPosts();
        self::assertCount(5, $retrievedPosts);
    }
}