// File: tests/Http/ControllerTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PostController;
use Pest\Laravel\Artisan;
use Pest\Laravel\Laravel;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $response = Artisan::get('migrate --force');

        $response->assertSuccessful();

        $posts = Post::all();

        $this->assertCount(1, $posts);
    }

    /**
     * @test
     */
    public function test_show_resource_not_found()
    {
        // Create a new post and delete it to ensure that the resource is not found.
        $post = factory(Post::class)->create()->delete();

        // Send a GET request to /posts/{id} where {id} is 1 (the ID of our deleted post).
        Artisan::get('migrate --force');

        $response = Laravel::get('/posts/1');

        $this->assertEquals(404, $response->getStatusCode());
    }
}