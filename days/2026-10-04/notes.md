# Eloquent Slow Query Detection

Eloquent is Laravel's ORM (Object-Relational Mapping) system. While it provides a convenient and intuitive way to interact with your database, it can also lead to performance issues if not used carefully.

One common issue is slow query detection. When Eloquent detects a slow query, it will log the query details to the `slow_queries` table in the database. However, by default, this logging is disabled, making it difficult to detect and address slow queries.

To enable slow query detection, you can modify the Eloquent configuration or create a custom detector class that extends the `Model` class. In this example, we'll use the latter approach.

The provided code defines an `EloquentSlowQueryDetector` class that extends the `Model` class. This class has two main methods:

1.  **`getSlowQueries($limit = 10)`**: This method returns a query builder instance that retrieves slow queries from the database. A slow query is defined as one that takes more than 100 milliseconds to execute.
2.  **`__construct()`**: The constructor initializes the `EloquentSlowQueryDetector` class by disabling the timestamp column and setting up the table name.

To test this detector, we can create a unit test using Pest or PHPUnit. In this example, we use PHPUnit.

The `EloquentSlowQueryDetectorTest` class extends the base `TestCase` class and provides a single test method, `testGetSlowQueries()`. This method creates 10,000 slow queries by creating 1,000 query instances with durations greater than 100 milliseconds. It then verifies that the detector returns exactly 10 slow queries.

By using this custom detector class, you can easily detect slow queries in your Eloquent models and address them accordingly to improve the overall performance of your application.

To use this detector in a real-world scenario:

1.  Create a new model that extends the `EloquentSlowQueryDetector` class.
2.  Use this model as needed in your application, just like any other Eloquent model.
3.  When slow queries are detected, log or handle them as needed to prevent performance issues.

Note: Make sure to adjust the threshold value (100 milliseconds) according to your specific use case and database configuration.