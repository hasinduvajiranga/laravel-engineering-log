// File: tests/Unit/EloquentColumnModificationsTest.php

namespace Tests\Unit\Eloquent;

use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class EloquentColumnModificationsTest extends TestCase
{
    public function testUserModelHasFillableColumns()
    {
        $user = new User();
        $this->assertArrayHasKey('name', $user->getAttributes());
        $this->assertArrayHasKey('email', $user->getAttributes());
    }

    public function testProductModelHasCastedColumn()
    {
        $product = new Product();
        $product->price = 10.99;
        $this->assertEquals(10.99, $product->price);
        $product->price = 'abc';
        $this->expectException(\InvalidArgumentException::class);
        $product->save();
    }

    public function testProductModelHasAttribute()
    {
        $product = new Product();
        $product->stock_quantity = 100;
        $this->assertEquals(100, $product->stock_quantity);
        $product->stock_quantity = 0;
        $this->assertEquals(0, $product->getOriginal('stock_quantity'));
    }
}