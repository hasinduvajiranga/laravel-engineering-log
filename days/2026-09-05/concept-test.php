// File: tests/Feature/SearchableTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Pest\Laravel\DuskTestCase;

class SearchableTest extends DuskTestCase
{
    use RefreshDatabase, DatabaseMigrations, WithoutMiddleware, WithFaker;

    public function test_fullTextSearch()
    {
        $user = User::factory()->create(['title' => 'Example Title']);

        $response = $this->get('/search', [
            'q' => 'example'
        ]);

        $response->assertSee($user->title);
    }
}