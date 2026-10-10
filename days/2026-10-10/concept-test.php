// tests/Feature/CategoryControllerTest.php
namespace Tests\Feature;

use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('category.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(count(Category::all()));
    }

    public function testExportJson()
    {
        // Mock the controller to return a response with JSON
        $controller = app(CategoryController::class);
        Request::set(['method' => 'GET']);
        $response = $controller->exportJson();
        $response->assertResponseJsonContent([]);
        $response->assertStatus(200);

        // Verify the exported data is correct
        $categories = Category::all();
        foreach ($categories as $category) {
            $this->assertEquals($category->name, json_decode($response->getContent(), true)['name']);
        }
    }

    public function testJsonExport()
    {
        // Mock the controller to return a response with JSON
        $controller = app(CategoryController::class);
        Request::set(['method' => 'GET']);
        $response = $controller->exportJson();
        $response->assertResponseJsonContent([]);
        $response->assertStatus(200);

        // Verify the exported data is correct
        $categories = Category::all();
        foreach ($categories as $category) {
            $this->assertEquals($category->name, json_decode($response->getContent(), true)['name']);
        }
    }

    public function testXmlExport()
    {
        // Mock the controller to return a response with XML
        $controller = app(CategoryController::class);
        Request::set(['method' => 'GET', 'xml' => '1']);
        $response = $controller->exportJson();
        $response->assertResponseIsXml();
        $response->assertStatus(200);

        // Verify the exported data is correct
        $categories = Category::all();
        foreach ($categories as $category) {
            $this->assertEquals($category->name, json_decode($response->getContent(), true)['name']);
        }
    }

    public function testInvalidFormat()
    {
        // Mock the controller to throw an exception for invalid format
        $controller = app(CategoryController::class);
        Request::set(['method' => 'GET', 'format' => 'invalid']);
        $this->expectException(\InvalidArgumentException::class);
        $response = $controller->exportJson();
    }
}