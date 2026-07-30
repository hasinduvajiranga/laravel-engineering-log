# Eloquent Model Events

Eloquent model events allow you to extend the functionality of your models by listening to specific events triggered during model operations. In this example, we've implemented three listeners: `CreatedUser`, `UpdatedUser`, and `DeletedUser`.

### Creating Event Listeners

To create an event listener, you must implement a class that implements the `ShouldQueue` interface. This allows Laravel to properly queue the event for processing.

```php
// App/Listeners/CreatedUser.php

namespace App\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatedUser implements ShouldQueue
{
    public function handle(Model $user)
    {
        // Handle the created user event
    }
}
```

### Registering Event Listeners

In your model, you can register event listeners using the `events` property. This property should be an array of events that should trigger specific listeners.

```php
// App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\EventListener\HasListeners;

class User extends Model implements HasListeners
{
    use HasListeners;

    protected $events = [
        'created' => ['App\Listeners\CreatedUser'],
        'updated' => ['App\Listeners\UpdatedUser'],
        'deleted' => ['App\Listeners\DeletedUser']
    ];
}
```

### Verifying Event Listeners

To verify that an event listener was triggered, you can use Laravel's built-in testing functionality. In this example, we're using the `DatabaseMigrationsTestCase` to verify that the listeners were triggered during model operations.

```php
// tests/Unit/App/Models/UserTest.php

namespace Tests\Unit\App\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrationsTestCase;

class UserTest extends DatabaseMigrationsTestCase
{
    public function testUserCreatedEvent()
    {
        $user = new User(['name' => 'John Doe', 'email' => 'john@example.com']);
        
        // Verify that the CreatedUser listener was triggered
        $this->assertNull($user->created_at);
        $this->assertInstanceOf(CreatedUser::class, app('listener')->get('created'));
    }
}
```

This example provides a deep-dive into Eloquent model events and how you can leverage them to extend the functionality of your models.