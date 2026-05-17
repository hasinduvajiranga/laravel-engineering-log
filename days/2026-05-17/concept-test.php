// tests/Feature/ProductControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use App\Product;
use App\Http\Controllers\ProductController;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        factory(Product::class, 10)->create();

        $this->browser->visit('/products');

        $this->browser->assertSeeInTitle('Products');
    }

    public function test_show()
    {
        $product = factory(Product::class)->create();

        $this->browser->visit('/products/' . $product->id);

        $this->browser->assertSeeInTitle($product->name);
    }

    public function test_index_caching()
    {
        $this->artisan('cache:clear');

        $this->browser->visit('/products');

        $this->browser->assertNotSeeInTitle('Products');

        Cache::forget('products');
    }
}