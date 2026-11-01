# Eloquent API Conditional Requests

In this example, we are going to implement a custom `EloquentRequest` class that extends Laravel's built-in `Request` facade. This class will allow us to make conditional requests to the API endpoint.

The key features of this implementation are:

*   We define a new class called `EloquentRequest` in the `App\Http\Libraries` namespace.
*   In the constructor, we perform any necessary validation or checks before making the request.
*   If the request is being made to a specific API endpoint (identified by the `api.*` route), we retrieve the model class associated with that endpoint and store it as an instance property.
*   We also define a second class called `EloquentApiRequest` in the same namespace, which extends our original `EloquentRequest` class. This new class allows us to pass conditions when making requests.

Using these custom request classes, we can make conditional requests to the API endpoint by passing conditions during the request object creation process.

Example usage:

```php
$request = new EloquentApiRequest(['condition' => function () {
    // Only perform certain actions when this condition is met
}]);
```

In this example, we create a new instance of our `EloquentApiRequest` class and pass a closure as the `condition` parameter. The closure will be executed during the request object creation process.

This allows us to make conditional requests to the API endpoint by passing conditions when creating the request object.

```php
use App\Http\Libraries\EloquentRequest;

$request = new EloquentRequest(['modelClass' => App\Models\MyModel::class]);
```

In this example, we create a new instance of our `EloquentRequest` class and pass the model class as a parameter when creating the request object. This allows us to make requests to specific endpoints without having to specify the endpoint in the route.

By using these custom request classes, you can implement conditional logic during your API requests and perform actions based on specific conditions.