# Eloquent Factory States

Eloquent factories are a powerful tool for creating instances of your Eloquent models. However, they also have some important states that you should be aware of.

### `hasFactory()`

This method checks if the factory has been registered and is ready to use. It does this by checking if the underlying database table exists.

### `definition()`

This method returns an array representing the data for a single instance of the model. This array can contain any fields that you want to be populated with fake data.

### Creating instances

Once you have created your factory, you can create instances of your models like this:

```php
$entity = EloquentFactory::new()->make();
```

The `make()` method returns an instance of the model without actually saving it to the database. If you want to save the instance, you can use the `create()` method instead.

### Using factories in tests

Factories are often used in unit tests and other types of tests to create mock data for your models. This helps ensure that your tests are more robust and less prone to failure due to external factors.

In our example above, we have a `FactoryTest` class that uses the factory to test its functionality.

### Best practices

Here are some best practices when working with Eloquent factories:

* Always use factories to create instances of your models. This helps ensure that your data is consistent and makes it easier to test your application.
* Use the `make()` method instead of the `create()` method whenever possible. The `make()` method returns an instance of the model without actually saving it, which can be more efficient for testing purposes.
* Always validate that the factory has been registered before using it. You can do this by calling the `hasFactory()` method on the factory.

By following these best practices and understanding the different states of Eloquent factories, you can write more robust and efficient code for your Laravel application.