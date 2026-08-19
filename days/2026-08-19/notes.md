# Eloquent Raw Expressions
Eloquent raw expressions allow you to use raw SQL in your queries. This can be useful when performing complex queries that cannot be achieved using Eloquent's standard syntax.

## Creating a Custom Scope

To create a custom scope, you need to define a `scopeRawWhere` or `scopeRawLike` method within your model. These methods will allow you to use the raw SQL expression.

```php
public function scopeRawWhere($query, $attribute, $value)
{
    return $query->whereRaw($attribute . '=', $value);
}

public function scopeRawLike($query, $column, $pattern)
{
    return $query->whereRaw($column . " LIKE ?", [$pattern]);
}
```

## Testing the Custom Scope

To test the custom scope, you can create a test class that extends `TestCase`. Within this test class, you can use the `DB` facade to execute raw SQL queries.

```php
public function testRawWhere()
{
    DB::statement('CREATE TABLE users (id INT, name VARCHAR(255), email VARCHAR(255))');
    \DB::table('users')->insert([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com'
    ]);

    $user = User::whereRaw('name', 'John Doe')->first();

    $this->assertEquals('John Doe', $user->name);

    DB::statement('DROP TABLE users');
}

public function testRawLike()
{
    DB::statement('CREATE TABLE users (id INT, name VARCHAR(255), email VARCHAR(255))');
    \DB::table('users')->insert([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com'
    ]);

    $user = User::whereRaw('email', '%' . 'example' . '%')->first();

    $this->assertEquals('john.doe@example.com', $user->email);

    DB::statement('DROP TABLE users');
}
```

## Limitations

While Eloquent raw expressions provide a lot of flexibility, they can also lead to security vulnerabilities if not used properly. Be sure to always sanitize your input and use parameter binding when executing raw SQL queries.

Also, be aware that using `DB` facade directly is generally discouraged in favor of Eloquent's standard syntax. Instead, consider using the `whereRaw` method on your model instance to execute raw SQL queries.