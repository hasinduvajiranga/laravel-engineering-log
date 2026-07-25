# Eloquent Relationship Lazy Loading

Eloquent provides a powerful relationship system for interacting with models in your application. One of the key features is lazy loading, which allows you to fetch related data on demand.

When defining relationships between models, Laravel will automatically create the necessary tables and queries to retrieve the associated data. However, by default, Eloquent retrieves all related data immediately when it's first requested. This can lead to performance issues if you're dealing with large datasets or complex relationships.

## Enabling Lazy Loading

To enable lazy loading for a relationship, use the `$with` method when retrieving an instance of the model:
```php
$user = User::with('posts')->get();
```
By default, Eloquent will only retrieve the specified columns. If you want to include all related data, pass an array of attribute names:
```php
$user = User::with(['posts' => ['id', 'title']])->get();
```
## Retrieving Related Data on Demand

To retrieve related data on demand, use the `load` method instead of `$with`. This allows you to specify only the attributes that you need:
```php
$user->load('posts');
```
When using `load`, Eloquent will only fetch the specified attributes from the database. If the relationship is a has-many relationship (like `User::posts()`), it will create an instance of the related model with the loaded data.

## Verifying Lazy Loading

To verify that lazy loading is working correctly, you can use the `Schema` facade to check if the necessary tables and columns exist in your database. For example:
```php
Schema::hasTable('users', function ($table) {
    return $table->hasColumn('posts_id');
});
```
This checks if there's a column named `posts_id` on the `users` table, which indicates that the relationship is being used.

By using lazy loading and eager loading techniques, you can improve performance and reduce unnecessary database queries in your Laravel application.