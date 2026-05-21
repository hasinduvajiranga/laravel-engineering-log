# Implicit Route Model Binding

Implicit Route Model Binding allows you to bind model instances to route parameters without explicitly defining them in your controller methods.

When using implicit Route Model Binding, Laravel will automatically inject the bound model instance into your controller method as an argument. This can make your code more concise and easier to read.

### How it Works

Behind the scenes, when you use a route parameter in your URL, Laravel uses its routing system to find the corresponding controller method that expects that parameter.

In this case, we're using the `id` parameter in our `/users/{id}` route. When we call `$request->input('id')`, Laravel automatically finds the model instance with an ID matching that value and binds it to our controller method as a new argument.

This feature is particularly useful when building CRUD controllers where you often need to access the model instance associated with a particular record.

### Best Practices

To get the most out of implicit Route Model Binding, follow these best practices:

*   Use route parameters in your URLs to bind model instances to specific records.
*   Define your controller methods as described in the [Laravel documentation](https://laravel.com/docs/8.x/routing#route-model-binding).
*   Use the `$request->input('parameter')` syntax to access route parameter values within your controller methods.

By leveraging implicit Route Model Binding, you can simplify your code and make it more efficient.