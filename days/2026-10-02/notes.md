# Eloquent Connection Pooling

Eloquent's connection pooling is a feature that allows you to use multiple database connections with a single instance of the `Model` class. This can be useful in scenarios where you need to switch between different databases, or where you want to reuse existing connections.

To enable connection pooling in your application, make sure you've set up the correct configuration for your database drivers. You'll also need to use the `$connection` property on your Eloquent models to specify which connection to use.

Here are some key points to keep in mind when using Eloquent's connection pooling:

*   **Database connections must be set up**: Make sure that you've set up the correct configuration for your database drivers, including setting up multiple connections.
*   **Use the `$connection` property on your models**: Set the `$connection` property on your Eloquent models to specify which connection to use. This can be done using a static method like `newConnection`.
*   **Be aware of the implications for transactions and migrations**: Since you're reusing existing connections, you'll need to make sure that you're handling transactions and migrations correctly.
*   **Watch out for potential issues with data consistency**: Connection pooling relies on sharing the same database connection between multiple instances. Be cautious when using this feature, as it can lead to data inconsistencies if not used properly.

In the example above, we've shown how to use Eloquent's connection pooling by setting up a different connection pool for our `User` model. We've also demonstrated how to test that the correct connection is being used using PHPUnit tests.