// tests/Unit Tests/UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_can_be_created()
    {
        $user = User::factory()->create();

        $this->assertIsInt($user->id);
        $this->assertEquals('john.doe@example.com', $user->email);
    }

    /**
     * @test
     */
    public function user_has_many_orders()
    {
        $user = User::factory()->create();

        $orders = Order::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->orders);
    }

    /**
     * @test
     */
    public function user_has_only_one_order()
    {
        $user = User::factory()->create();

        $orders = Order::factory()->count(1)->create(['user_id' => $user->id]);

        $this->assertCount(1, $user->orders);
    }

    /**
     * @test
     */
    public function user_can_retrieve_orders()
    {
        $user = User::factory()->create();

        $order1 = Order::factory()->create(['user_id' => $user->id]);
        $order2 = Order::factory()->create(['user_id' => $user->id]);

        $orders = $user->orders;

        $this->assertEquals($order1, array_shift($orders));
        $this->assertEquals($order2, $orders[0]);
    }
}