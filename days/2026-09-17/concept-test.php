// tests/Database-Seeds/CreateUsersTableSeederTest.php

namespace Tests\Database\Seeders;

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