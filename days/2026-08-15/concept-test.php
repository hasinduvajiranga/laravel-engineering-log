// tests/Feature/OrderProductTest.php

namespace Tests\Feature;

use App\Models\OrderProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Factory;
use Tests\TestCase;

class OrderProductTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;

    public function testOrderProductRelation()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $orderProduct = OrderProduct::factory()->create(['product_id' => $product->id, 'order_id' => $order->id]);

        $this->assertCount(1, $product->orders());
    }

    public function testOrderRelation()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $orderProduct = OrderProduct::factory()->create(['product_id' => $product->id, 'order_id' => $order->id]);

        $this->assertCount(1, $order->products());
    }

    public function testEloquentPivotTableRelation()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $orderProduct = EloquentPivotTable::factory()->create(['product_id' => $product->id, 'order_id' => $order->id]);

        $this->assertCount(1, $product->orders());
    }
}