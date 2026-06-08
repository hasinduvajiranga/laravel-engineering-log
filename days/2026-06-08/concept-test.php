// File: tests/Http/Controllers/BooksControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BooksControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function it_can_index_books()
    {
        $response = $this->get('/books');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure(['data' => [
            'id',
            'title',
            'author_id'
        ]]);
    }

    /**
     * @test
     */
    public function it_can_create_book()
    {
        $book = new Book();
        $book->title = 'Test Book';
        $book->author_id = 1;
        $book->save();

        $response = $this->post('/books', [
            'title' => 'New Test Book',
            'author_id' => 2
        ]);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Book created successfully']);
    }

    /**
     * @test
     */
    public function it_can_show_book()
    {
        $book = new Book();
        $book->title = 'Test Book';
        $book->author_id = 1;
        $book->save();

        $response = $this->get('/books/' . $book->id);
        $response->assertStatus(200);
        $response->assertJson(['id' => $book->id, 'title' => $book->title, 'author_id' => $book->author_id]);
    }

    /**
     * @test
     */
    public function it_can_update_book()
    {
        $book = new Book();
        $book->title = 'Test Book';
        $book->author_id = 1;
        $book->save();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'Updated Test Book',
            'author_id' => 2
        ]);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Book updated successfully']);
    }

    /**
     * @test
     */
    public function it_can_delete_book()
    {
        $book = new Book();
        $book->title = 'Test Book';
        $book->author_id = 1;
        $book->save();

        $response = $this->delete('/books/' . $book->id);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Book deleted successfully']);
    }
}