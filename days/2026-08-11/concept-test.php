// File: tests/Unit/Model/UserTest.php

namespace Tests\Unit\Model;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a new user and order item.
        $user = User::create(['name' => 'John Doe']);
        $orderItem = OrderItem::factory()->create(['product_id' => 1, 'quantity' => 10]);

        // Associate the user with the order item.
        $orderItem->user()->associate($user);
    }

    /**
     * @test
     */
    public function a_user_has_many_orders_through_order_items()
    {
        // Get the orders associated with the user.
        $orders = User::with('orders')->first();

        // Assert that there are two orders for the user.
        $this->assertEquals(2, $orders->orders()->count());
    }

    /**
     * @test
     */
    public function an_order_item_has_one_user()
    {
        // Get the order item with its associated user.
        $orderItem = OrderItem::first();

        // Assert that there is a user for the order item.
        $this->assertInstanceOf(User::class, $orderItem->user());
    }
}