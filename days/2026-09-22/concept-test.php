// File: tests/Database/MigrationsTest.php

namespace Tests\Database;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Database\Migrations\CreateUsersTable;

class MigrationsTest extends TestCase
{
    use DatabaseMigrations;

    public function testMigrationRollback()
    {
        $this->artisan('migrate');
        // simulate a database error during migration
        $this->artisan('migrate:rollback');

        $migration = new CreateUsersTable();
        $migration->up();

        // verify that the table was not created before rolling back
        $this->assertDatabaseHasNotBeenRecentlyCreated(['users']);

        $migration->down();
    }
}