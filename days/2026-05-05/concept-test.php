// File: tests/Services/UserServiceTest.php

namespace Tests\Services;

use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory(10)->create()->each(function ($user) {
            $this->cache->forget($user->id);
        });
    }

    public function testGetUsers()
    {
        $userService = new UserService();
        $users = $userService->getUsers();

        $this->assertCount(10, $users);

        // Check if the cache is working correctly
        $this->assertEquals(60, $this->cache->getExpiration($users));
    }

    public function testGetUser()
    {
        $userService = new UserService();
        $user = User::factory()->create();

        $this->assertNull($userService->getUser(''));

        $this->assertEquals(60, $this->cache->getExpiration($user));

        // Check if the cache is working correctly
        $this->assertTrue($this->cache->has($user->id));
    }

    public function testCreateUser()
    {
        $userService = new UserService();
        User::factory()->create();

        $this->assertNull(User::find(1)->avatar_path());

        // Test that the cache is cleared when a user is created
        $this->cache->forget('users');

        $this->assertEmpty($this->cache->get('users'));
    }
}