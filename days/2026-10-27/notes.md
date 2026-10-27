# Eloquent API Status Codes

API status codes are used to indicate the outcome of an HTTP request. In Laravel, we can use Eloquent to define our models and their respective API endpoints.

When creating a controller, you typically want to handle specific HTTP requests (e.g., GET, POST, PUT, DELETE) in separate methods. Each method should return a JSON response containing relevant data or an error message.

## Valid Status Codes

Here are some valid status codes that you may encounter when working with API endpoints:

*   **200 OK**: The request was successful.
*   **201 Created**: A new resource was created.
*   **204 No Content**: The request was successful, but no content was returned.
*   **404 Not Found**: The requested resource could not be found.
*   **500 Internal Server Error**: An unexpected error occurred.

## Handling Errors

In Laravel, you can use the `response()->json()` method to return a JSON response. This method will automatically set the HTTP status code based on the type of exception that was thrown.

For example:

```php
public function show($id)
{
    $user = User::find($id);
    if (!$user) {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
    }
    return response()->json(['data' => $user], 200);
}
```

In this case, the `ModelNotFoundException` will be caught by Laravel's built-in error handling mechanism and returned as a 404 status code.

## API Status Code Definitions

You can define your own custom HTTP status codes using the `\Illuminate\Http\Response` class. This is typically used for debugging or testing purposes.

```php
use Illuminate\Http\Response;

public function show($id)
{
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 600); // Custom status code: 600
    }
    return response()->json(['data' => $user], 200);
}
```

In this example, the `show()` method will return a JSON response with a custom HTTP status code of 600.