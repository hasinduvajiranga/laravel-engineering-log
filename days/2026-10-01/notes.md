# Eloquent Read Write Connections

In Laravel, you can specify read and write connections for your models using the `connection` property on the model. The `getReadConnection()` and `getWriteConnection()` methods allow you to retrieve these connections programmatically.

By default, Eloquent will use a "mysql" connection for reads and writes when no specific connection is specified. However, you can change this behavior by specifying a different connection in your model.

The `getReadConnection()` method returns the read connection used by the model, while the `getWriteConnection()` method returns the write connection used by the model. These methods are useful when you need to switch between read-only and read-write operations on the same model.

You can also use these methods to test your connections programmatically.

Note: When using multiple connections in Laravel, make sure to configure them correctly in your `config/database.php` file.