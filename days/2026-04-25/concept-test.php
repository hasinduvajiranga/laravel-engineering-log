// tests/Unit/Services/UserServiceTest.php

namespace Tests\Unit\Services;

use App\Services\UserService;
use App\Models\User;
use Laravel\Sanctum\LaravelUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateUser()
    {
        $service = new UserService();
        $user = $service->create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => bcrypt($user->password),
        ]);
    }

    public function testRestoreUser()
    {
        $service = new UserService();
        $user = $service->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'test_password',
        ]);

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $restoredUser = $service->restoreUser($user);

        $this->assertInstanceOf(User::class, $restoredUser);
        $this->assertEquals($user->name, $restoredUser->name);
        $this->assertEquals($user->email, $restoredUser->email);
    }
}