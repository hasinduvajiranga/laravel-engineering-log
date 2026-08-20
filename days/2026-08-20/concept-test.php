// tests/UserTest.php
namespace Tests\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetUsersTimeout()
    {
        $this->app->bind('DB', function ($app) {
            return new MockDB();
        });

        $user = new User();

        DB::table('users')->where('created_at', '<', now()->subMinutes(15))->insert(['name' => 'Test User', 'email' => 'test@example.com']);

        $this->assertEmpty($user->getUsers());

        // Wait for the timeout to occur
        sleep(20);

        $this->assertTrue(count($user->getUsers()) > 0);
    }

    public function testGetAllUsersTimeout()
    {
        $this->app->bind('DB', function ($app) {
            return new MockDB();
        });

        $user = new User();

        DB::table('users')->where('created_at', '<', now()->subMinutes(15))->insert(['name' => 'Test User', 'email' => 'test@example.com']);

        // Wait for the timeout to occur
        sleep(20);

        $this->assertTrue(count($user->getAllUsers()) > 0);
    }
}