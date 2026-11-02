// File: tests/Feature/ProductETags.php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Laravel Sanctum;
use Tests\TestCase;

class ProductETagsTest extends TestCase
{
    use RefreshDatabase, LaravelSanctum;

    public function testProductEtag()
    {
        $product = factory(Product::class)->create();

        // Get the ETag for the product before modifying it.
        $etagBefore = $product->getEtag(new Request());

        $product->name = "New Name";
        $product->save();

        // Get the ETag for the product after modifying it.
        $etagAfter = $product->getEtag(new Request());

        $this->assertEquals($etagBefore, $etagAfter);

        // Modify the ETags of all products.
        Product::all()->map(function ($product) {
            $product->touches = true;
            $product->save();
        });

        // Get the ETag for a new product that has not been modified yet
        $newProductEtag = factory(Product::class)->create()->getEtag(new Request());

        $this->assertNotEquals($etagBefore, $newProductEtag);
    }
}