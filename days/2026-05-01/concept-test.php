// tests/Feature/ProductControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use WithF Faker, RefreshDatabase;

    public function test_index()
    {
        $product = factory(Product::class)->create();

        $response = $this->get(route('products.index'));

        $response->assertJson(['data' => $product]);
        $response->assertJsonFragment([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
        ]);
    }

    public function test_index_with_cache()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.index'));

        Cache::forget('products');

        $response = $this->get(route('products.index'));

        $response->assertJson(['data' => ['id' => $product->id, 'name' => $
$product->name, 'price' => $product->price]]);
    }
}