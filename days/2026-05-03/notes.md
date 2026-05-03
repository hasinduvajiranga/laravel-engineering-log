# Laravel Advanced Performance Optimization

In this example, we will explore two advanced performance optimization tech
techniques in Laravel: Eager Loading and Relationship Caching.

## Eager Loading

Eager loading allows you to fetch related models with the main model in a s
single database query. This can significantly improve performance by reduci
reducing the number of queries made to the database.

```php
// Example usage:
User::with('posts')->get();
```

In this example, Laravel will fetch all users and their associated posts in
in a single query.

## Relationship Caching

Relationship caching is a feature introduced in Laravel 8.0 that allows you
you to cache relationships between models. This can be particularly useful 
when working with Eager Loading.

```php
// Example usage:
$user->load('posts');
```

In this example, the `load` method will cache the posts relationship for th
the specified user, reducing the number of queries made to the database.

## Best Practices

* Always use eager loading when fetching large amounts of data or complex r
relationships.
* Use relationship caching to improve performance in scenarios where eager 
loading is not feasible.
* Consider using pagination or other techniques to limit the amount of data
data fetched from the database.