# Eloquent Model Factory Sequences

Eloquent model factory sequences are a powerful tool in Laravel for creating instances of your Eloquent models. They allow you to create factories that can generate random data for your models, making it easier to test and integrate with other parts of your application.

## Using the `create()` method on a factory

The `create()` method is used to create a new instance of a model using the values provided by the factory.

```php
$user = User::factory()->create();
```

This will create a new user with random data, such as a name and email address.

## Using the `count()` method on a factory

The `count()` method is used to generate a specific number of instances for the model using the values provided by the factory.

```php
$orders = Order::factory()->count(2)->create(['user_id' => $user->id]);
```

This will create two new orders for the user, each with random data such as a total and status.

## Retrieving generated models

Once you've created a model using a factory, you can retrieve it from your database or use it in further tests.

```php
$orders = $user->orders;
```

This will return an array of orders associated with the user. You can then iterate over this array and perform assertions on the data.

## Best practices

When creating factories for Eloquent models, keep the following best practices in mind:

*   Use the `create()` method to create new instances of your models.
*   Use the `count()` method to generate a specific number of instances for the model using the values provided by the factory.
*   Always retrieve generated models from your database or use them in further tests.