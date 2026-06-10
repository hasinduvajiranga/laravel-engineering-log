# Controller Middleware Assignment

In Laravel, middleware can be used to assign data to the request or session based on authentication status. In this example, we'll create a custom middleware that assigns the authenticated user's ID to the session.

## How It Works

The `AssignControllerMiddleware` class uses the `check` method of the `Illuminate\Http\Request` instance to verify whether the request contains an authenticated user. If authentication is present, it assigns the user's ID to the session using the `put` method. If no authentication is found, it throws an exception.

## Testing

To test this middleware, we'll create two tests: one that verifies the middleware assigns the user ID to the session when authentication is present and another that confirms an exception is thrown when no authentication is detected.