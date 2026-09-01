# Eloquent Model Events vs Observers

Eloquent, Laravel's ORM, provides two ways to handle events: model events and observers. While both can be used for the same purpose – notifying listeners of model-related events – they have distinct differences.

## Model Events

Model events are built-in to the Eloquent class and provide a convenient way to execute code when certain events occur on an instance of a model (e.g., creating, updating, deleting). This approach is more straightforward but can be limited in terms of event handling flexibility.

When using model events, you define methods that start with `created`/`updated`/`deleted` followed by the name of the attribute being modified. These methods are called automatically when the specified events occur on an instance of a model.

```php
class User extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            // Event triggered when a user is being created
            event(new CreatedUserEvent($user));
        });

        static::updated(function (User $user) {
            // Event triggered when a user's details are being updated
            event(new UpdatedUserEvent($user));
        });
    }
}
```

## Observers

Observers, on the other hand, provide more flexibility in terms of event handling. An observer is a listener that can handle events in any scope and at any time.

You define observers by creating a class that implements the `Observer` interface, where you need to implement the methods for each event type (e.g., `created`, `updated`, etc.). The `listen` method allows you to specify which events an observer should listen for.

```php
class CreatedUserEvent extends Model
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('created_user');
    }

    public function handle()
    {
        // Handle the created user event here
        Log::info("User created: " . $this->user->name);
    }
}
```

## Comparison

|  | Model Events | Observers |
|