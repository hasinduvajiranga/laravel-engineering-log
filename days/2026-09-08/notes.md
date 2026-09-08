# Eloquent Lazy Eager Loading

Eloquent lazy eager loading is a technique used to improve performance by only fetching related data when it's actually needed. In traditional eager loading, all related data is fetched in a single query, which can be inefficient for large datasets.

### How it works

When you use the `with()` method on an Eloquent model, it will fetch all the relationships specified as an argument and store them in an array. The actual fetching of related data only happens when you access the relationship property.

For example, if we have a User model with a posts relationship, and we do `$user->posts`, Eloquent lazy eager loading kicks in:

*   It checks if `posts` is already stored in the `$user` instance.
*   If it's not, it queries the database for all the related posts and stores them in an array on the `$user` instance.

### Benefits

1.  **Improved performance**: By only fetching data when needed, you avoid unnecessary database queries.
2.  **Reduced memory usage**: You don't have to store a large amount of data in memory if it's not actually being used.

### Best practices

*   Use `with()` method on Eloquent models for lazy eager loading.
*   Only fetch the relationships that are actually needed.
*   Avoid using `$with` property directly, as it can lead to unexpected behavior.