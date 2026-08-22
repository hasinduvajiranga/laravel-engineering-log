# Eloquent Model Scoping with Traits

Eloquent models in Laravel provide a robust way to define relationships between models and perform queries on the data. However, sometimes you need to extend or modify this behavior using custom scoping methods.

One way to achieve this is by creating a trait that contains the custom scoping logic. The trait can then be used by any model that needs to use this custom behavior.

## Defining the Trait

```php
trait EloquentModelScoper
{
    /**
     * Scope the query to only include records where the column is within the given range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $column
     * @param  int  $min
     * @param  int  $max
     * @return void
     */
    public function scopeWithinRange($query, $column, $min, $max)
    {
        return $query->whereBetween($column, [$min, $max]);
    }
}
```

## Using the Trait

To use this trait in a model, simply extend it using the `use` keyword.

```php
class User extends Model
{
    use EloquentModelScoper;

    //...
}
```

## Defining Custom Scoping Methods

Once the trait is used by a model, you can define custom scoping methods on the model itself. These methods should use the `scopeWithinRange` method defined in the trait.

```php
class User extends Model
{
    use EloquentModelScoper;

    //...

    /**
     * Scope the query to only include records where the post's creation date is within a given range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $minDate
     * @param  int  $maxDate
     * @return void
     */
    public function scopeByPostCreated($query, $minDate, $maxDate)
    {
        return $this->posts()->whereBetween('created_at', [$minDate, $maxDate])->get();
    }
}
```

## Testing Custom Scoping

To test the custom scoping methods on a model, you can use Pest or PHPUnit.

```php
// Test the custom scoping trait using Pest
use App\Models\User;
use Tests\TestCase;

class EloquentModelScoperTest extends TestCase
{
    public function testCustomScopingTrait()
    {
        // Create a new user with some sample data
        $user = User::create(['name' => 'John Doe', 'post_id' => 1, 'created_at' => now()->subDays(5)]);
        $user->posts()->create(['title' => 'Sample Post 1']);

        // Test the scopeWithinRange method on the user model
        $query = User::query();
        $result = $query->withinRange('created_at', now()->subDays(2), now());
        self::assertCount(1, $result);

        // Reset the query and test the scopeByPostCreated method
        $query->reset();

        $result = $query->byPostCreated(now()->subDays(5), now());
        self::assertCount(1, $result);
    }

    public function testInvalidScoping()
    {
        // Create a new user with some sample data
        $user = User::create(['name' => 'John Doe', 'post_id' => 1, 'created_at' => now()->subDays(5)]);
        $user->posts()->create(['title' => 'Sample Post 1']);

        // Test that an error is thrown when trying to use the scopeWithInvalidRange method
        $this->expectException(\InvalidArgumentException::class);
        User::query()->scopeWithInvalidRange('created_at', 'now');
    }
}
```

This example demonstrates how you can create a custom scoping trait and use it in a model to extend its behavior. The trait provides a `withinRange` method that can be used to scope the query on any column, while the model defines a custom method `byPostCreated` that uses this method to filter records by post creation date.