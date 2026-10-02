// tests/UserTest.php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use App\Models\User;
use DatabaseMigrationsException;

class UserTest extends TestCase
{
    use DatabaseMigrationsException;

    public function testConnectionPooling()
    {
        // Create a new instance of the User model with a different connection pool
        $user = User::newConnection('sqlite', 'users');

        // Assert that the correct connection was used for the query
        $this->assertEquals('sqlite', $user->getConnection());
    }
}