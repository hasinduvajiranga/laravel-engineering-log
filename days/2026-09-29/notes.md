# Eloquent Query Expressions

Eloquent query expressions allow you to build complex queries without the need for raw SQL. These expressions provide a powerful and expressive way to filter data in your models.

## Defining Eloquent Query Expressions

To define an Eloquent query expression, you can use the `whereBetween` method on your model. This method allows you to specify a range of values for a particular column.

```php
// Get orders by date range
$users = User::getOrdersByDateRange($startDate, $endDate);
```

## Using Eloquent Query Expressions with Relationships

You can also use Eloquent query expressions with relationships. For example, if you have a `User` model that belongs to an `Order`, you can use the `whereBetween` method on the `orders` relationship to get orders by date range.

```php
// Get users with orders between these dates
$users = User::with('orders')->getOrdersByDateRange($startDate, $endDate);
```

## Testing Eloquent Query Expressions

When testing Eloquent query expressions, you can use PHPUnit and Laravel's built-in testing features to ensure that your queries are returning the correct results.

```php
// Test get orders by date range
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
```