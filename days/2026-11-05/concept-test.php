// File: tests/Http/EloquentApiStreamingControllerTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Testable;
use Tests\TestCase;
use App\Models\Book;

class EloquentApiStreamingControllerTest extends TestCase
{
    use RefreshDatabase, Testable;

    public function testIndexReturnsBooksPublishedInLastMonth()
    {
        Book::factory(10)->create(['published_date' => now()->subMonth()->format('Y-m-d')]);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'books');
    }

    public function testShowReturnsBookDetails()
    {
        Book::create([
            'title' => 'Test Book',
            'author_id' => 1,
            'published_date' => now()->subMonths(2)->format('Y-m-d'),
        ]);

        $response = $this->getJson('/api/books/1');

        $response->assertStatus(200);
        $response->assertJson(['id', 'title', 'author_id', 'published_date']);
    }

    public function testShowThrowsNotFoundException()
    {
        $book = Book::factory()->create();

        $response = $this->getJson('/api/books/999');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'Not Found']);
    }
}