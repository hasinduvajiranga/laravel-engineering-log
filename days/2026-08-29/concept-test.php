// File: tests/Feature/UserTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Passport\HasApiTokens;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, HasApiTokens;

    public function testUserPasswordIsNotSettable()
    {
        $user = factory(User::class)->create();

        // Try to set password using the model
        $response = $this->patchJson(route('users.update', ['user' => $user->id]), ['password' => 'new-password']);

        $response->assertStatus(422);
        $response->assertJson(['errors' => ['password' => 'The password must be at least 8 characters.',]]);

        // Try to set password using Eloquent's setPasswordAttribute
        $user->password = 'new-password';
        $user->save();

        $this->assertEquals('new-password', $user->password);
    }
}