# Eloquent API Fallback Responses

When building an API with Laravel's Eloquent ORM, you often want to provide a fallback response when the requested resource is not found. This can be done by overriding the `show` method in your controller and returning a 404 response.

In our example, we've created a simple `PostController` that returns all posts from the database when the index route is accessed. However, for demonstration purposes, we've also added a `show` method that attempts to retrieve a post with ID 1 (which doesn't exist). If this method is called, it will return a 404 response.

To test this behavior, we use Pest's Laravel features to send a GET request to the `/posts/1` route and verify that the response code is 404. We also ensure that any database migrations are ran before testing by calling `Artisan::get('migrate --force')`.

By providing a fallback response in this way, you can ensure that your API handles unexpected situations gracefully.

**Evaluating Eloquent API Fallback Responses**

When evaluating Eloquent API fallback responses, consider the following best practices:

*   Always override the `show` method in your controller if you need to handle cases where a requested resource is not found.
*   Use HTTP status codes (such as 404) to indicate that a requested resource was not found. This will help clients understand what went wrong and can improve their error handling.
*   Consider implementing a generic fallback response, such as a JSON object with an error message or a list of possible errors, when dealing with unexpected situations.

By following these guidelines and using Eloquent API fallback responses effectively, you can build robust APIs that handle unexpected situations gracefully.