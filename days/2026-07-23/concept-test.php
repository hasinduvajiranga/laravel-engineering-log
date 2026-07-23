// tests/Unit Tests/UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testScopeActiveUsers()
    {
        $user = factory(User::class)->create(['name' => 'John Doe', 'is_active' => 0]);
        $users = User::activeUsers()->get();
        $this->assertCount(1, $users);
        $this->assertEquals($user->id, $users[0]->id);
    }

    public function testScopeSearchByName()
    {
        factory(User::class)->create(['name' => 'John Doe']);
        factory(User::class)->create(['name' => 'Jane Doe']);
        User::searchBy_name('Doe')->get()->assertCount(2);
    }
}