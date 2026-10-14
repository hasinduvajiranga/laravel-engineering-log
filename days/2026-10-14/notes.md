# Eloquent API Error Handling

In Laravel, we can handle API errors using the `ExceptionHandler` class. However, when dealing with custom exceptions like Eloquent's `ApplicationException`, we need to implement our own error handling mechanism.

We create a custom exception class `ApiException` that extends Laravel's `HttpException`. This class has properties for code, message, and errors.

In our controller, we use this exception class to handle errors. When an exception is thrown, the `handleError` method of the `ErrorHandlingService` class is called to process the error.

The `ErrorHandlingService` class uses Laravel's built-in response helpers to create a JSON response with the error message and code. If the error has multiple errors (like in Eloquent), we can loop through them and add each error as a separate entry in the error array.

To test our error handling mechanism, we use Pest to send a request to our API endpoint and verify that the expected error status is returned.

We also create a test class `ControllerTest` to test the `ApiController` controller. In this test, we simulate an error by throwing an `ApplicationException`. We then verify that the response has the correct status code and content.

By implementing custom exception handling in our API, we can provide more informative error messages to our clients and improve the overall user experience.