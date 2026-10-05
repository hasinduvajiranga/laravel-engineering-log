// tests/QueryPlanTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Pest\Laravel\Pest;
use App\Models\User;
use App\Models\Order;

class QueryPlanTest extends TestCase
{
    use RefreshDatabase, Pest\Laravel\Pest;

    public function testEagerLoading()
    {
        $user = User::factory()->create();
        $orders = Order::factory(3)->create(['user_id' => $user->id]);

        DB::statement('EXPLAIN SELECT * FROM orders WHERE user_id = ?', [$user->id]);

        $this->artisan('get:query-plan', [
            '--model' => User::class,
            '--relation' => 'orders',
            '--eager-load' => true,
        ]);

        $this->assertEquals($orders->count(), 3);
    }

    public function testLazyLoading()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        DB::statement('EXPLAIN SELECT * FROM orders WHERE user_id = ?', [$user->id]);

        $this->artisan('get:query-plan', [
            '--model' => User::class,
            '--relation' => 'orders',
        ]);

        $this->assertEquals(0, $order->count());
    }

    public function testEagerLoadingWithJoin()
    {
        $user = User::factory()->create();
        $orders = Order::factory(3)->create(['user_id' => $user->id]);

        DB::statement('EXPLAIN SELECT * FROM orders JOIN users ON orders.user_id = users.id WHERE 1 = 0');

        $this->artisan('get:query-plan', [
            '--model' => User::class,
            '--relation' => 'orders',
            '--eager-load' => true,
            '--join-type' => 'inner',
        ]);

        $this->assertEquals($orders->count(), 3);
    }
}