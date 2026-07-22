// tests/Feature/UserQueryScope.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Pest\Laravel\VCRTestCase;

class UserQueryScopeTest extends VCRTestCase
{
    use DatabaseMigrations, WithFaker;

    public function testActiveUsers()
    {
        $user = factory(User::class)->create(['is_active' => true]);
        $users = User::active()->get();

        $this->assertCount(1, $users);
        $this->assertEquals($user->id, $users[0]->id);
    }

    public function testAdminUsers()
    {
        factory(User::class)->create(['role' => 'admin']);
        factory(User::class)->create(['role' => 'user']);

        $admins = User::admin()->get();

        $this->assertCount(1, $admins);
        $this->assertEquals('admin', $admins[0]->role);
    }
}