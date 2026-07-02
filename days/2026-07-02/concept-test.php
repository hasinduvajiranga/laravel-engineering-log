// File: tests/Feature/ProductControllerTest.php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        // Test that the index page displays all products with pagination links
        $response = $this->get(route('products.index'));

        $response->assertViewIs('products.index');
        $response->assertViewHas('products', Product::all());
        $response->assertSeeText('All Products');
    }

    public function testShow()
    {
        // Test that the show page displays product details
        $product = factory(Product::class)->create();

        $response = $this->get(route('products.show', ['product' => $product->id]));

        $response->assertViewIs('products.show');
        $response->assertViewHas('product', $product);
    }

    public function testRelatedProducts()
    {
        // Test that the related products are displayed using a Blade scope
        factory(Product::class)->create(['related_products' => 1]);
        factory(Product::class)->create(['related_products' => 2]);

        $response = $this->get(route('products.show', ['product' => Product::where('id', 1)->first()->id]));

        $response->assertViewIs('products.related');
    }

    public function testAttributes()
    {
        // Test that product attributes are displayed using a Blade scope
        factory(Product::class)->create(['description' => 'test description']);

        $product = Product::where('id', 1)->first();

        $response = $this->get(route('products.show', ['product' => $product->id]));

        $response->assertViewIs('products.show');
        $response->assertViewHas('attributes', [
            'description' => $product->description,
        ]);
    }
}