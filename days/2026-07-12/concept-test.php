// tests/Http/Resources/BooksResourceTest.php

namespace Tests\Http\Resources;

use App\Http\Resources\BookResource;
use Illuminate\Foundation\Testing\DatabaseMigrationsTestCase;
use Illuminate\Http\Response;

class BookResourceTest extends DatabaseMigrationsTestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testBookResource()
    {
        // Create a new book resource with genres
        $book = factory(Book::class)->create([
            'title' => 'The Great Gatsby',
            'author_id' => 1,
            'genres_id' => [1, 2],
        ]);

        // Create a new request for the book resource
        $response = $this->getJson(route('api/books.' . $book->id));

        // Assert that the response contains the expected data
        $response->assertJson([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author->name,
            'published_at' => $book->created_at->format('Y-m-d H:i:s'),
            'genres' => ['Genre 1', 'Genre 2'], // Note: array_map is used to preserve the order of genres
        ]);
    }
}