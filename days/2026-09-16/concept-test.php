// tests/Http/PaginatorControllerTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithApplicationErrors;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Model;

class PaginatorControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase, WithApplicationErrors, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        Model::factory(20)->create();
    }

    public function test_index()
    {
        $response = $this->get('/paginator');

        $response->assertViewIs('paginator.index');
        $response->assertJson(['total' => 20, 'per_page' => 10]);

        // Test pagination links
        $links = ['prev', 'next'];
        foreach ($links as $link) {
            $response = $this->get('/paginator?page=' . $link);
            $response->assertViewIs('paginator.index');
            $response->assertJson(['total' => 20, 'per_page' => 10]);
        }
    }

    public function test_index_with_custom_page_size()
    {
        $request = Request::forge(['page' => 1, 'per_page' => 50]);
        $response = $this->get('/paginator', [$request]);

        $response->assertJson(['total' => 20, 'per_page' => 50]);
    }
}