# Eloquent Raw SQL Queries

Eloquent, Laravel's ORM, provides a simple and intuitive way to interact with your database. However, there are times when you need more control over the queries or want to avoid some of the overhead that comes with using Eloquent.

In this section, we will explore how to use raw SQL queries with Eloquent in Laravel.

## Using Raw SQL Queries

To perform a raw SQL query with Eloquent, you can use the `DB` facade and its methods like `table`, `select`, etc. The general syntax is as follows:

```php
DB::table('table_name')->select('column1', 'column2')->get();
```

This will execute a SELECT statement on the specified table and return the results.

### Querying Multiple Tables

If you want to query multiple tables, you can use the `join` method or use a subquery.

```php
DB::table('users')
    ->join('orders', 'users.id', '=', 'orders.user_id')
    ->select('users.name', 'orders.order_date')
    ->get();
```

Or,

```php
DB::table('users')
    ->whereHas('orders')
    ->select('users.name', 'orders.order_date')
    ->get();
```

### Using Raw SQL with Eloquent Models

You can also use raw SQL queries directly on an Eloquent model by casting the query to a `Collection`.

```php
$users = User::query()->where('name', 'John')->selectRaw('count(*) as total_orders')->first();
```

In this example, we are using the `selectRaw` method to perform a raw SQL query and then casting it to a `Collection` so that it can be accessed like an Eloquent model.

### Security Considerations

When using raw SQL queries with Eloquent, you need to be aware of security considerations. Make sure to use parameter binding or prepared statements to prevent SQL injection attacks.

```php
DB::table('users')
    ->where('name', '=', 'John')
    ->get();
```

In this example, we are using the `=` operator with a parameter bound value to prevent SQL injection.

By following these examples and guidelines, you can effectively use raw SQL queries with Eloquent in Laravel.