# Eloquent Cross-Database Queries

Eloquent cross-database queries allow you to access data from multiple databases using Eloquent's ORM capabilities. This can be useful in scenarios where you have data duplicated across different databases, or when you need to perform cross-database joins.

## Using the Primary and Secondary Database Connections

To use Eloquent's primary and secondary database connections, create separate classes for each connection. These classes should extend `Illuminate\Database\Eloquent\Model` and provide methods for accessing the data from each database.

For example:
```php
class PrimaryDatabase extends Model
{
    public static function getPrimaryConnection()
    {
        return DB::connection('primary');
    }

    public function users()
    {
        return self::getPrimaryConnection()->table('users')->get();
    }
}
```

## Using the Cross-Database Query Class

To use the cross-database query class, create a new instance of `CrossDatabaseQuery` and call its methods to access data from each database.

For example:
```php
$crossDBQuery = new CrossDatabaseQuery();

$primaryDBUsers = $crossDBQuery->getUsersFromPrimary();
$secondaryDBUsers = $crossDBQuery->getUsersFromSecondary();
```

## Testing the Cross-Database Queries

To test the cross-database queries, create a separate test class that extends `Illuminate\Foundation\Testing\TestCase`. Use the `DB::connection()` method to access each database connection and assert that the data retrieved from one database is not equal to the data retrieved from another.

For example:
```php
class CrossDatabaseQueryTest extends TestCase
{
    public function testGetUsersFromPrimary()
    {
        $crossDBQuery = new CrossDatabaseQuery();

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertEquals(count($primaryDBUsers), count($secondaryDBUsers));
    }

    public function testGetDifferentDataFromBothDatabases()
    {
        $crossDBQuery = new CrossDatabaseQuery();

        $primaryDBConnection = DB::connection('primary');
        $secondaryDBConnection = DB::connection('secondary');

        $primaryDBUsers = $primaryDBConnection->table('users')->get();
        $secondaryDBUsers = $secondaryDBConnection->table('users')->get();

        self::assertNotEquals($primaryDBUsers, $secondaryDBUsers);
    }
}
```

## Conclusion

Eloquent cross-database queries provide a flexible and efficient way to access data from multiple databases using Eloquent's ORM capabilities. By following the example above and creating separate classes for each database connection, you can easily access data from both primary and secondary databases in your Laravel application.