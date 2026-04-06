// File: tests/Console/Commands/CreateUserTest.php

namespace Tests\Console\Commands;

use App\Console\Commands>CreateUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\DB;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateUserSuccess()
    {
        $this->artisan('create:user', ['name' => 'John Doe', 'email' => 'jo
'john@example.com']);
        $user = User::where('email', 'john@example.com')->first();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
    }

    public function testCreateUserFail()
    {
        $this->artisan('create:user', ['name' => 'John Doe', 'email' => 'jo
'john@example.com']);
        $this->artisan('create:user', ['name' => 'Jane Doe', 'email' => 'jo
'john@example.com']);

        $user = User::where('email', 'john@example.com')->first();

        $this->null($user);
    }

    public function testCreateUserFailExisting()
    {
        $this->artisan('create:user', ['name' => 'John Doe', 'email' => 'jo
'john@example.com']);
        $this->artisan('create:user', ['name' => 'Jane Doe', 'email' => 'jo
'john@example.com']);

        $user = User::where('email', 'john@example.com')->first();

        $this->assertInstanceOf(User::class, $user);
    }
}