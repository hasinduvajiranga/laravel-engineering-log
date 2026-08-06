### Eloquent JSON Column Queries

Laravel's Eloquent ORM provides a powerful query builder that allows you to perform complex queries on your database. When it comes to querying JSON columns, Eloquent provides two ways to achieve this: `whereJsonExists` and `whereJsonContains`.

#### whereJsonExists

The `whereJsonExists` method is used to check if a JSON column exists in the data of another model. It takes three parameters:

*   The first parameter is the name of the JSON column.
*   The second parameter is the value that you want to search for.
*   The third parameter is an optional closure that can be used to filter the results.

Example:
```php
$books = Book::whereJsonExists('description', ['search query'])
    ->orWhereJsonContains('tags', ['query'])
    ->get();
```

#### whereJsonContains

The `whereJsonContains` method is used to check if a JSON column contains a certain value. It takes three parameters:

*   The first parameter is the name of the JSON column.
*   The second parameter is the value that you want to search for.
*   The third parameter is an optional closure that can be used to filter the results.

Example:
```php
$books = Book::whereJsonExists('description', ['search query'])
    ->orWhereJsonContains('tags', ['query'])
    ->get();
```

Both methods allow you to use closures to further filter the results. This means you can add additional conditions to your queries using Eloquent's built-in filtering syntax.

When using `whereJsonExists` or `whereJsonContains`, keep in mind that these methods will only return a boolean value (true or false) indicating whether the JSON column exists or contains the specified value, respectively. If you need to retrieve the actual data that matches the query, you'll need to use a different approach.

By leveraging Eloquent's built-in support for JSON queries, you can create powerful and efficient queries that help you extract insights from your data.