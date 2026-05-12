// File: tests/Feature/SearchControllerTest.php

namespace Tests\Feature;

use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestSuite;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search()
    {
        // Create a new search record with keyword 'test'
        $this->artisan('db:seed', ['--class' => SearchModel::class, '--name
'--name' => 'new-record']);

        $response = $this->get('/search', [
            'q' => 'test',
            'timeout' => 30,
        ]);

        $response->assertJson(['keyword' => 'test', 'description' => 'This 
is a test record']);
    }

    public function test_search_cached_results()
    {
        // Create a new search record with keyword 'test'
        $this->artisan('db:seed', ['--class' => SearchModel::class, '--name
'--name' => 'new-record']);

        Cache::forget($this->app->SearchController->cachePrefix . 'test');

        $response = $this->get('/search', [
            'q' => 'test',
            'timeout' => 30,
        ]);

        // Wait for the cache to be refreshed
        $this->app->time = 60;

        $response->assertJson(['keyword' => 'test', 'description' => 'This 
is a test record']);
    }
}