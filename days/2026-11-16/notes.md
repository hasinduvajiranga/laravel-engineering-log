# Eloquent API Logging Strategies

In this example, we'll explore a deep-dive technical approach to logging model updates in Laravel using the Eloquent ORM. We'll use the `Illuminate\Database\Eloquent\Model` class and create an `EloquentLogger` class that extends the Laravel logger facade.

### Model Update Event Handling

To handle model update events, you can utilize the `each()` method on the model instance to iterate through all instances of a specific model type. Within this loop, we use the `Log::info()` method to record the update event for each model instance.

```php
logUpdate() {
    $this->model->each(function ($instance) {
        Log::info(
            "Updated instance: {$instance->getOriginal('created_at') ?? 'N/A'} - {$instance->id}",
            ['extra' => 'Eloquent Logger']
        );
    });
}
```

### Creating the EloquentLogger Class

To create an instance of the `EloquentLogger` class, you need to pass a model instance into its constructor. This will allow you to access all instances of a specific model type using the `$this->model` property.

```php
class EloquentLogger {
    private $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }
}
```

### Model Creation and Test

To verify that the `EloquentLogger` class is working correctly, we create a test model instance using the `Illuminate\Database\Eloquent\Model` class. We then instantiate an instance of the `EloquentLogger` class and log update events for this model instance.

```php
public function testEloquentLogger()
{
    // Create a mock model instance
    $model = new \Illuminate\Database\Eloquent\Model(['id' => 1, 'created_at' => now()]);

    // Create an instance of the logger
    $logger = new EloquentLogger($model);

    // Log update events
    $logger->logUpdate();

    // Verify that the log message was recorded correctly
    $this->assertEquals('Updated instance: N/A - 1', Log::recorded('Eloquent Logger'));

    // Log create event
    $logger->logCreate();

    // Verify that the log message was recorded correctly
    $this->assertEquals('Created instance: 2023-03-20 14:30:00 - 1', Log::recorded('Eloquent Logger'));
}
```