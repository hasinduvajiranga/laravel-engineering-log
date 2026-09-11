// tests/Feature/PaginationTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;

class PaginationTest extends TestCase
{
    public function test_pagination()
    {
        // Create a fresh database
        factory(Book::class, 10)->create();

        $response = $this->get('/pagination');

        $response->assertViewIs('pagination.index');
        $response->assertSessionHas('books');
        $response->assertJsonCount(10);
    }

    public function test_pagination_with_custom_per_page()
    {
        // Create a fresh database
        factory(Book::class, 20)->create();

        $response = $this->get('/pagination?per_page=5');

        $response->assertViewIs('pagination.index');
        $response->assertSessionHas('books');
        $response->assertJsonCount(4);
    }
}