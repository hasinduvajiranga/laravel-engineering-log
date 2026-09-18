### Eloquent Seeder Progress Bars

**Why Use Progress Bars in Seeders?**

When seeding a database, it's essential to provide feedback on the progress of the seeder. This can be particularly useful for large datasets or when seeding multiple tables.

**Creating a Custom Seeder with Progress Bar**

In Laravel 8 and above, you can use the `ProgressBar` facade to create a custom seeder that displays a progress bar.

Firstly, make sure to register the `ProgressBar` facade in your `config/app.php` file:
```php
'providers' => [
    // ...
    Illuminate\Support\Facades\ProgressBar::class,
],
```

Then, create a new seeder class that extends the `Seeder` class and use the `ProgressBar` facade to create a progress bar:
```php
namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\ProgressBar;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $bar = ProgressBar::create('Seeding users table');

        // Your seeder logic here

        // Advance the progress bar after each successful insertion
        $bar->advance(1);
    }
}
```

**Testing Seeders with Progress Bars**

When testing seeders, you can use the `artisan` command to run the seeder and verify that the progress bar is displayed correctly.

Create a new test class that extends the `TestCase` class and use the `DatabaseMigrations` trait:
```php
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTableSeederTest extends TestCase
{
    use DatabaseMigrations;

    public function test_seeding_users_table()
    {
        $this->artisan('seed:users');

        // Verify that the users table has been seeded correctly
        // ...
    }
}
```

In this example, we've created a custom seeder that uses a progress bar to display the progress of the seeding process. We've also included an example test class that verifies that the progress bar is displayed correctly when running the seeder using the `artisan` command.