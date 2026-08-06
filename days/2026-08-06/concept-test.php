// File: tests/Http/Controllers/JsonQueryControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Book;
use App\Http\Controllers\JsonQueryController;
use Tests\TestCase;

class JsonQueryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndexReturnsJsonResponse()
    {
        $this->actingAs($this->createUser()->id);
        $response = $this->getJson(route('index'));

        $response->assertJsonStructure(['data']);
    }

    public function testJsonQueryReturnsResults()
    {
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();

        $response = $this->postJson(route('jsonQuery'), ['query' => 'test']);

        $response->assertJsonStructure(['results']);
        $response->assertJsonCount(1, 'results');
    }

    public function testJsonQueryReturnsResultsForJsonExists()
    {
        $book = Book::factory()->create();
        $book->description = json_encode(['search query' => 'test']);
        $book->save();

        $response = $this->postJson(route('jsonQuery'), ['query' => 'test']);

        $response->assertJsonStructure(['results']);
        $response->assertJsonCount(1, 'results');
    }

    public function testJsonQueryReturnsResultsForJsonContains()
    {
        $book = Book::factory()->create();
        $book->tags = json_encode(['query' => 'test']);
        $book->save();

        $response = $this->postJson(route('jsonQuery'), ['query' => 'test']);

        $response->assertJsonStructure(['results']);
        $response->assertJsonCount(1, 'results');
    }
}