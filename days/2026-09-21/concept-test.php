// File: tests/Database/Migrations/EloquentMigrationTest.php

namespace Tests\Database\Migrations;

use App\Database\Migrations\CreateUsersTable;
use Illuminate\Database\MigrationException;
use Pest\TestCase;

class EloquentMigrationTest extends TestCase
{
    /**
     * @test
     */
    public function test_migrate()
    {
        $this->artisan('migrate');

        $migration = new CreateUsersTable();
        $migration->up();

        $table = Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        $this->assertTrue($table->hasColumn('name'));
        $this->assertTrue($table->hasColumn('email'));
        $this->assertTrue($table->hasColumn('password'));
        $this->assertTrue($table->hasColumn('_remember_token'));
        $this->assertTrue($table->hasColumns(['created_at', 'updated_at']));
    }

    /**
     * @test
     */
    public function test_down()
    {
        $migration = new CreateUsersTable();
        $migration->up();

        $migration->down();

        $table = Schema::table('users');

        $this->assertFalse($table->hasColumn('name'));
        $this->assertFalse($table->hasColumn('email'));
        $this->assertFalse($table->hasColumn('password'));
        $this->assertFalse($table->hasColumn('_remember_token'));
        $this->assertFalse($table->hasColumns(['created_at', 'updated_at']));
    }
}