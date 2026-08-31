# Eloquent Restoring Hooks

Eloquent restoring hooks allow you to perform custom actions before or after a model is restored. These hooks are registered through the `EloquentRestoringServiceProvider` class.

## Registering Restoration Hooks

To register restoration hooks, create an instance of the `App\Providers\EloquentRestoringServiceProvider` class and add your hook callbacks to the `$restorationHooks` array. For example:

```php
$restorationHook = new \stdClass();
$restorationHook->action = 'beforeRestore';
$restorationHook->data = ['model_name' => 'TestModel'];

$this->restorationHooks['beforeRestore'][] = function ($event) {
    // Perform custom action before restoration.
};

// Register the hook
$this->registerRestorationHooks();
```

## Types of Restoration Hooks

Eloquent restoring hooks support two types:

*   **`beforeRestore`**: This type is executed just before a model is restored.
*   **`afterRestore`**: This type is executed just after a model is restored.

You can register custom hook callbacks for these types by adding them to the `$restorationHooks` array.

## Testing Restoration Hooks

To test restoration hooks, create an instance of the `App\Providers\EloquentRestoringServiceProviderTest` class and use the `setUpRestorationLog()` method to set up a sample model in the database. Then, assert that the restoration hook callbacks were executed correctly using the `$restorationHooks` array.

## Conclusion

Eloquent restoring hooks provide a convenient way to perform custom actions before or after a model is restored. By registering these hooks through the `EloquentRestoringServiceProvider` class and testing them using the `setUpRestorationLog()` method, you can ensure that your application's restoration process meets your specific needs.

Example use cases for Eloquent restoring hooks include:

*   Validating data before saving it to the database.
*   Performing additional processing after a model has been restored from the database.
*   Sending notifications or emails when a model is restored.

By leveraging these hooks, you can create more robust and reliable applications that meet your specific business requirements.