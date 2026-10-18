// tests/Feature/ProductControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelOpenApi\OpenApi\Tests\TestCase;
use App\Models\Product;
use App\Http\Controllers\ProductController;

class ProductControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        // Create a product and save it to the database
        $product = new Product(['name' => 'Product 1', 'description' => 'This is product 1']);
        $product->save();

        // Make an HTTP GET request to /products
        $response = $this->get('/products');

        // Assert that the response is a JSON object with products
        $response->assertJson(['products' => [
            ['id', intval($product->id)],
            ['name', $product->name],
            ['description', $product->description],
        ]]);
    }

    public function testShow()
    {
        // Create a product and save it to the database
        $product = new Product(['name' => 'Product 1', 'description' => 'This is product 1']);
        $product->save();

        // Make an HTTP GET request to /products/1
        $response = $this->get('/products/' . $product->id);

        // Assert that the response is a JSON object with single product
        $response->assertJson(['product' => [
            ['id', intval($product->id)],
            ['name', $product->name],
            ['description', $product->description],
        ]]);
    }
}