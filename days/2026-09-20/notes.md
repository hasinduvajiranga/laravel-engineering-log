# Eloquent Stateful Factories

Eloquent stateful factories are a powerful tool for creating testable models in Laravel. They allow you to define a factory that creates instances of your model with specific attributes and relationships.

## Benefits

*   **Reduced Test Complexity**: By defining the attributes and relationships for each model, you can reduce the complexity of your tests.
*   **Improved Test Durability**: Eloquent stateful factories ensure that your tests are more durable and less prone to failures due to external factors like database schema changes or new data being inserted.

## How It Works

Eloquent stateful factories use a combination of the `TestableFactory` class from Laravel's testing facade and the `Definition` method provided by the factory. The `definition` method is where you define the attributes and relationships for your model.

Here are some key points to consider when using Eloquent stateful factories:

*   **Use the `with` Method**: When defining a relationship between models, use the `with` method to ensure that the related model is properly loaded.
*   **Use the `create` Method**: When creating a new instance of your model, use the `create` method to specify the attributes for that instance.

## Example Use Case

Here's an example of how you might use Eloquent stateful factories in your tests:

```php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\Factory as TestableFactory;

class User extends Model
{
    use TestableFactory;

    protected $fillable = ['name', 'email'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```

```php
// tests/FactoryTest.php

namespace Tests\Factories;

use App\Factories\EloquentStatefulFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Tests\DuskTestCase;

class FactoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_eloquent_stateful_factory()
    {
        // Create a new instance of the factory with some attributes
        $factory = app(EloquentStatefulFactory::class);
        $user = $factory->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'post_id' => 1,
        ]);

        // Verify that a Post was created and associated with the User
        $this->assertDatabaseHas($user->id, ['posts' => 1]);
    }
}
```

In this example, we've defined an `EloquentStatefulFactory` for the `User` model. The factory creates instances of the `User` model with specific attributes and relationships. We then use the factory to create a new instance of the `User` model and verify that it's properly associated with another model (in this case, a `Post`).