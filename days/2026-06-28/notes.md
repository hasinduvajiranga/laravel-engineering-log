# Redirect Response Customization

Laravel provides a built-in `response()->view()` method for creating custom redirect responses. However, this method does not provide much flexibility when it comes to customizing the response.

In this example, we'll demonstrate how to create a custom redirect controller that returns a custom view with a URL parameter.

The `RedirectController` class extends the base `Controller` class and defines a single method `showCustomRedirect`. This method takes a `$url` parameter and returns a `Response` object created using the `response()->view()` method. The `view` function is passed two arguments: the name of the view to render (`'redirect'`) and an array with the URL as a key-value pair.

To test this custom redirect controller, we'll create a test class `RedirectControllerTest` that extends Laravel's `DuskTestCase`. This test class uses the `RefreshDatabase` trait to ensure a clean database before each test.

The first test method `testShowCustomRedirect` tests that the custom redirect response is returned correctly. It sends a GET request to the `/redirect.show` route with a URL parameter and asserts that the response contains the expected view name (`'Redirect Response'`) and redirects to the provided URL.

The second test method `testShowCustomRedirectWithQueryParams` tests that the custom redirect response handles query parameters correctly. It sends a GET request to the `/redirect.show` route with a URL parameter and an additional query parameter, and asserts that the response contains both the view name and the query parameter in the redirect URL.

By customizing the `response()->view()` method, we can create more complex and flexible redirect responses using Laravel's routing system.