# Eloquent Dynamic Scopes
Eloquent dynamic scopes allow you to define and reuse complex query logic in your model classes.

## Benefits

*   **Encapsulation**: Dynamic scopes encapsulate the complexity of the queries, making it easier to maintain and update.
*   **Reusability**: You can reuse the same scope across multiple models or even within the same model for different purposes.
*   **Decoupling**: Dynamic scopes help decouple your queries from the specific implementation details.

## Creating a Dynamic Scope

To create a dynamic scope, you define an `activeUsers` method in your User model. This method takes a `Builder` instance as its parameter and applies the necessary conditions to retrieve active users.

```php
public function scopeActiveUsers(Builder $builder)
{
    return $builder->where('is_active', 1);
}
```

In this example, the `activeUsers` scope filters out inactive users by applying the `where` clause on the `is_active` column.

## Applying a Dynamic Scope

To apply a dynamic scope to your query, you use the `with` or `use` method:

```php
User::activeUsers()->get(); // Retrieves active users
```

Alternatively, you can also define multiple scopes in your model and then use them as needed.

### Using Multiple Scopes

You can combine multiple scopes by chaining them together. For instance:

```php
public function scopeActiveSearchBy_name(Builder $builder, string $name)
{
    return $builder->where('is_active', 1)->searchBy_name($name);
}
```

In this case, the `activeSearchBy_name` scope will retrieve only active users who have a name matching `$name`.

### Dynamic Scope with Parameters

You can pass parameters to your dynamic scopes just like any other method. For example:

```php
public function scopeActiveUsersWithAgeRange(Builder $builder, int $minAge = 18, int $maxAge = null)
{
    if ($maxAge === null) {
        $builder->where('age', '>=', $minAge);
    } else {
        $builder->whereBetween('age', [$minAge, $maxAge]);
    }
}
```

In this case, you can apply the `activeUsersWithAgeRange` scope with or without age range parameters:

```php
User::activeUsersWithAgeRange(20, 30)->get(); // Retrieves active users aged between 18 and 30
User::activeUsers()->get(); // Retrieves all active users
```