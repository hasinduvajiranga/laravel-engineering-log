# Eloquent Query Scopes

Eloquent query scopes are a powerful feature in Laravel that allows you to extend the functionality of your Eloquent models. They provide a way to filter data before it is retrieved from the database, allowing for more efficient and flexible querying.

### Defining Query Scopes

To define a query scope, create a new method on your model class. This method should take an instance of `Illuminate\Database\Eloquent\Builder` as its first argument, followed by any additional arguments that you wish to pass to the query builder.

For example:
```php
public function scopeActive($query)
{
    return $query->where('is_active', true);
}
```
This would add a new method called `active()` to your model class, which can be used to filter results based on the `is_active` column.

### Using Query Scopes

To use a query scope, simply call the corresponding method on an instance of your model:
```php
$users = User::active()->get();
```
This would retrieve all users who have an `is_active` value of true.

### Best Practices

*   Keep your query scopes concise and focused on a single operation. Avoid using them for complex logic that could be handled by the database or through other means.
*   Use meaningful names for your query scopes. This will make it easier for others to understand what they do.
*   Consider caching query scope results, especially if you have frequently used scopes.

### Advanced Usage

You can also pass arguments to your query scopes:
```php
public function scopeActiveByDate($query, $date)
{
    return $query->where('created_at', '>=', $date);
}
```
This would add a new method called `activeByDate()` that takes an additional argument, which is used to filter results based on the `created_at` column.