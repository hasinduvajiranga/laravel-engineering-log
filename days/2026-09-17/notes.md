### Eloquent Database Seeding

Eloquent database seeding is a mechanism in Laravel for populating your database with initial data. It provides a convenient way to seed data into your database after installation.

**Step 1: Create a Seeder Class**

Create a new seeder class by extending the `DatabaseSeeder` class and naming it according to the model you want to seed (e.g., `CreateUsersTableSeeder`). This class will contain methods that insert data into the corresponding table in the database.

```php
use Illuminate\Database\Seeder;

class CreateUsersTableSeeder extends Seeder
{
    public function run()
    {
        // Insert data into the users table
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
```

**Step 2: Register the Seeder**

In your `DatabaseSeeder` class, register the seeder you created in Step 1.

```php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([CreateUsersTableSeeder::class]);
    }
}
```

**Step 3: Seed the Database**

Run the `DatabaseSeeder` class to seed your database with initial data. You can do this by running the following command in your terminal:

```bash
php artisan db:seed
```

This will execute the seeder and insert data into your database.

### Testing Seeding

To test that seeding is working correctly, create a new test class that extends `TestCase` and uses the `DatabaseMigrations` trait. This test class can verify that the expected amount of data was seeded into the database.

```php
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use App\Database\Seeders\CreateUsersTableSeeder;
use Tests\TestCase;

class CreateUsersTableSeederTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function test_seeds_users_table()
    {
        // Run the seeder and check that the users are inserted into the database
        $seeder = new CreateUsersTableSeeder();
        (new CreateUsersTableSeeder())->run();

        $users = User::all();

        // Assert that exactly two users were seeded
        self::assertCount(2, $users);
    }
}
```

Run the test using the following command in your terminal:

```bash
phpunit tests/Database-Seeds/CreateUsersTableSeederTest.php
```

This will execute the test and verify that the expected amount of data was seeded into the database.