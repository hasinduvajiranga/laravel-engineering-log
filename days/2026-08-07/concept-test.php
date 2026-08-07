// File: tests/Feature/SearchControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\SearchableModel;
use App\Http\Controllers-searchController;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_search_results()
    {
        // Create a searchable model with translatable attributes
        $searchableModel = new SearchableModel();
        $searchableModel->name = 'Hello World';
        $searchableModel->save();

        // Perform search query
        $response = $this->get('/search', ['q' => 'hello']);

        // Assert search results are displayed on the page
        $this->assertSessionHas('searchResults');
    }

    public function test_no_search_results()
    {
        // Create a searchable model with no translatable attributes
        $searchableModel = new SearchableModel();
        $searchableModel->save();

        // Perform search query without input
        $response = $this->get('/search');

        // Assert no search results are displayed on the page
        $this->assertSessionHas('message', 'No search results found');
    }
}