// tests/UserTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_usersWithCursor()
    {
        User::usersWithCursor();
    }

    public function test_usersWithForCursor()
    {
        User::usersWithForCursor();
    }

    public function test_usersWithSkipCursor()
    {
        User::usersWithSkipCursor();
    }

    public function test_usersWithLimitCursor()
    {
        User::usersWithLimitCursor();
    }
}