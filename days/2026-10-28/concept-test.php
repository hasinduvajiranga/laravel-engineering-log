// File: tests/Http/ControllerTest.php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Services\LoginService;

class AuthControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testShowLoginForm()
    {
        $response = $this->get(route('login'));
        $response->assertViewIs('auth.login');
    }

    public function testLoginSuccess()
    {
        // Create a new user with valid credentials.
        $user = User::create([
            'email' => 'test@example.com',
            'password' => bcrypt('test'),
        ]);

        // Test the login functionality with valid credentials.
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'test',
        ]);

        $response->assertExactJson(['token' => $user->getKey()]);
    }

    public function testLoginFailure()
    {
        // Create a new user with invalid credentials.
        $user = User::create([
            'email' => 'invalid@example.com',
            'password' => bcrypt('test'),
        ]);

        // Test the login functionality with invalid credentials.
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong',
        ]);

        $response->assertExactJson(['error' => 'Invalid credentials'], 401);
    }
}