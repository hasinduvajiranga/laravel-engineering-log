# Eloquent Global Scopes

Eloquent global scopes allow you to reuse complex scopes in multiple classe
classes and models. A global scope is defined using the `scope` method on a
a model class.

## Benefits of Using Global Scopes

*   Reduced code duplication: By defining a global scope, you can reuse it 
across multiple models without having to duplicate the logic.
*   Improved maintainability: Global scopes make it easier to manage comple
complex business logic, as it's encapsulated in a single method.
*   Simplified testing: With global scopes, you can test individual classes
classes more easily, as they don't have to implement complex scope logic.

## Defining a Global Scope

To define a global scope, use the `scope` method on your model class. The m
method takes a string argument, which will be used as the scope name.

```php
public function scopeAdminUsers($query)
{
    return $query->where('role', 'admin');
}
```

## Using Global Scopes

To apply a global scope to a query, use the scope name on your model class,
class, followed by parentheses containing any required parameters.

```php
$users = User::adminUsers()->get();
```

In this example, we're applying the `adminUsers` scope to our user query. T
The scope will filter the results to only include users with an admin role.
role.

## Examples of Global Scopes

*   Filtering by department:
    ```php
public function scopeDepartmentUsers($query, $departmentId)
{
    return $query->where('department_id', $departmentId);
}
```
*   Filtering by name range:
    ```php
public function scopeByNameRange($query, $minName, $maxName)
{
    return $query->whereBetween('name', [$minName, $maxName]);
}
```
By defining and using global scopes effectively, you can simplify your Eloq
Eloquent codebase and improve maintainability.