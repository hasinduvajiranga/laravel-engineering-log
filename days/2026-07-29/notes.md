# Eloquent Cursor Iteration

Eloquent's `cursor` method allows you to iterate over a query using an iterator. It's more efficient than loading the entire result set into memory.

## For Cursor

The `forCursor` method is similar to `cursor`, but it stops iterating when the specified condition is met.

```php
// $result = DB::table('users')
            ->where('name', 'like', '%John%')
            ->forCursor(function ($row) {
                return true;
            })
            ->get();
```

In this example, the query will stop as soon as it finds a row where `name` starts with 'John'.

## Skip Cursor

The `skipCursor` method skips a specified number of rows before starting to iterate over the result set.

```php
// $result = DB::table('users')
            ->where('name', 'like', '%John%')
            ->skip(2)
            ->cursor(function ($row) {
                return true;
            })
            ->get();
```

In this example, the query will skip two rows before starting to iterate over the result set.

## Limit Cursor

The `limitCursor` method limits the number of rows that are returned in the result set.

```php
// $result = DB::table('users')
            ->where('name', 'like', '%John%')
            ->limit(3)
            ->cursor(function ($row) {
                return true;
            })
            ->get();
```

In this example, the query will only return three rows where `name` starts with 'John'.

Eloquent's cursor methods are more efficient than loading the entire result set into memory. They're especially useful when working with large datasets or when you need to perform complex filtering or sorting on a large dataset.