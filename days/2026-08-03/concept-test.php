// File: tests/Feature/Product.php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestSuiteTestCase;
use Illuminate\Support\Facades\DB;

class ProductTest extends TestSuiteTestCase
{
    use RefreshDatabase;

    public function testEloquentAppendableAttributes()
    {
        $category = factory(ProductCategory::class)->create(['name' => 'Electronics']);
        $product = factory(Product::class)->create([
            'name' => 'Apple iPhone',
            'description' => 'A high-end smartphone',
            'categories_id' => $category->id,
        ]);

        // Create some product attributes
        DB::table('product_attributes')->insert([
            ['name' => 'Color', 'value' => 'Silver'],
            ['name' => 'Ram', 'value' => '6GB'],
        ]);

        // Check if the product has the correct number of product attributes
        $this->assertEquals(2, $product->attributes()->count());

        // Get a specific attribute and check its relation to the product
        $attribute = ProductAttribute::firstWhere('name', 'Color');
        $this->assertInstanceOf(Product::class, $attribute->product());
    }
}