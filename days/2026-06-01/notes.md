# Route Conditionals

Route conditionals allow you to make certain routes available or unavailable based on specific conditions. This can be achieved using the `Route::when` and `Route::middleware` methods in Laravel.

**Using `Route::when`:**

The `Route::when` method is used to add a condition to a route. It checks if the specified middleware is present in the request, and if not, redirects the user to the fallback route.

```php
Route::get('/test', 'TestController@test')->when('isAdmin', 'TestController@anotherTest');
```

In this example, the `/test` route will only be accessible when the `isAdmin` middleware is present. If it's absent, the request will be redirected to the `/another-test` route.

**Using `Route::middleware`:**

The `Route::middleware` method is used to apply a middleware group to a route. You can use this to add a condition to your route by checking if the middleware is present in the request.

```php
Route::get('/test', 'TestController@test')->middleware('canAccess');
```

In this example, the `/test` route will only be accessible when the `canAccess` middleware is present. If it's absent, the request will be denied.

**Using Route Conditionals with Eloquent Models:**

You can also use route conditionals to check if a model exists or not. Here's an example:

```php
Route::get('/users/{id}', function ($id) {
    $user = User::where('id', $id)->first();
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }
    // Return the user data
});
```

In this example, the `/users/{id}` route will only be accessible when a user with the specified ID exists in the database. If the user doesn't exist, a 404 status code is returned.

**Route Conditionals and Request Parameter**

You can also use route conditionals to check if a request parameter has a specific value. Here's an example:

```php
Route::get('/test', 'TestController@test')->when('isAdmin', 'TestController@anotherTest');
```

In this example, the `/test` route will only be accessible when the `isAdmin` request parameter is set to `true`. If it's absent or has a different value, the request will be denied.

By using route conditionals in Laravel, you can make your routes more secure and conditional. This allows you to restrict access to certain resources based on user permissions or other conditions, making your application more robust and reliable.