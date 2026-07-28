// tests/Models/PostTest.php

namespace Tests\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Post;
use Illuminate\Pagination\Paginator;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetPostsChunked()
    {
        // Create a large number of posts
        for ($i = 0; $i < 100; $i++) {
            Post::factory()->create();
        }

        // Get the first page of chunked posts
        $posts = Post::getPostsChunked(10);

        // Check if there are 10 posts in the response
        $this->assertEquals(10, count($posts));

        // Check if the total number of records is still 100
        $this->assertEquals(100, Post::count());

        // Reset the pagination
        Paginator::reset();
    }
}