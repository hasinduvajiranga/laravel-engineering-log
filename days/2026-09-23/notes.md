# Eloquent Schema Builder
Eloquent's schema builder provides a simple and intuitive way to define your database tables.

### Defining Model Relationships

When defining relationships between models using Eloquent, you can use the `belongsToMany` or `hasMany` methods. These methods allow you to specify the foreign key on the related table.

```php
// File: app/Models/User.php

class User extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

In this example, we're defining a `posts` method that returns a `hasMany` relationship to the `Post` model. This tells Eloquent to create a foreign key on the `users` table for the `post_id` column.

### Defining Model Attributes

When creating or updating data in your database, you can use Eloquent's schema builder to specify the attributes that should be included or excluded from the request. You can do this using the `$fillable` property.

```php
// File: app/Models/User.php

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
```

In this example, we're defining a `$fillable` array that specifies which columns should be mass-assignable. This is important for security reasons, as it prevents malicious requests from injecting arbitrary data into your database.

### Eloquent Migration

When you first create a new model in Laravel, Eloquent will automatically generate a migration file to create the corresponding database table. However, if you want to modify an existing table or add a new column, you'll need to create a custom migration using the `php artisan migrate` command.

```bash
// File: app/Models/User.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

In this example, we're defining a custom migration that creates the `users` table with the specified columns.

### Schema Builder Best Practices

When using Eloquent's schema builder, keep the following best practices in mind:

* Use `$fillable` to specify which columns should be mass-assignable.
* Define relationships between models using `belongsToMany` or `hasMany`.
* Use migrations to modify existing tables or add new columns.
* Keep your migration files organized and up-to-date.