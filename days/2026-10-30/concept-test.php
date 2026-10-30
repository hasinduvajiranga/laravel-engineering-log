// tests/Feature/Livewire/SessionStateTest.php

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestSuitable;
use App\Http\Livewire\LoginForm;
use App\Http\Livewire\SessionState;

class SessionStateTest extends TestSuitable
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        // Mock user input validation
        $response = Livewire::test(SessionState::class)
            ->actingAs(fn ($session) => [
                'email' => 'user@example.com',
                'password' => 'password'
            ])
            ->call('login');

        $this->assertEquals(302, $response->status());
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Mock user input validation
        $response = Livewire::test(SessionState::class)
            ->actingAs(fn ($session) => [
                'email' => 'invalid-user@example.com',
                'password' => 'wrong-password'
            ])
            ->call('login');

        $this->assertEquals(302, $response->status());
    }

    public function test_user_can_logout()
    {
        // Mock user input validation
        $response = Livewire::test(SessionState::class)
            ->actingAs(fn ($session) => [
                'email' => 'user@example.com',
                'password' => 'password'
            ])
            ->call('logout');

        $this->assertNull(Livewire::test(SessionState::class)->sessionId());
    }

    public function test_session_state_is_not_null_after_logout()
    {
        // Mock user input validation
        $response = Livewire::test(SessionState::class)
            ->actingAs(fn ($session) => [
                'email' => 'user@example.com',
                'password' => 'password'
            ])
            ->call('logout');

        $this->assertNotNull(Livewire::test(SessionState::class)->sessionId());
    }
}