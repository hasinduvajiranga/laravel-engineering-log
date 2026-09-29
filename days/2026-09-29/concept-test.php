// File: Tests/Models/UserTest.php

namespace Tests\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetOrdersByDateRange()
    {
        // Create some users with orders
        $user1 = factory(User::class)->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $user1->orders()->create(['order_number' => 1, 'total' => 100.0]);
        $user2 = factory(User::class)->create(['name' => 'Jane Doe', 'email' => 'jane@example.com']);
        $user2->orders()->create(['order_number' => 2, 'total' => 200.0]);

        // Test the query expression
        $results = User::getOrdersByDateRange('2022-01-01', '2022-12-31');

        // Assert that only one user has orders between these dates
        self::assertCount(1, $results);

        // Assert that the correct order is returned for each user
        foreach ($results as $user) {
            $order = $user->orders()->first();
            self::assertEquals($order['order_number'], 1);
            if ($user === $user2) {
                self::assertEquals($order['total'], 200.0);
            }
        }
    }

    public function testGetOrdersByDateRangeWithNoResults()
    {
        // Test the query expression with no orders between these dates
        $results = User::getOrdersByDateRange('2999-12-31', '1970-01-01');

        // Assert that no results are returned
        self::assertCount(0, $results);
    }
}