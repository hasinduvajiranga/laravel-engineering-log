# Eloquent API Session State

In Laravel, the session state is managed by the `Session` facade. The `Eloquent` ORM provides a convenient way to store and retrieve data from the session using the `$session` property.

When building an API with Laravel Livewire, it's essential to handle the session state correctly. In this example, we'll demonstrate how to implement Eloquent API session state using Livewire.

**Step 1: Create a Livewire component**

Create a new file `app/Http/Livewire/SessionState.php` and add the following code:
```php
namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class SessionState extends Component
{
    public $sessionId;

    public function __construct()
    {
        parent::__construct();

        if (Auth::check()) {
            $this->sessionId = Auth::id();
        }
    }

    // ...
}
```
**Step 2: Implement login functionality**

In the `login` method, validate user input and use the `Auth::attempt` method to log in the user. Update the session state with the new user ID:
```php
public function login(Request $request)
{
    // Validate and validate user input
    $validatedData = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
    ]);

    // Login user and update session state
    if (Auth::attempt($validatedData)) {
        Session::put('sessionId', Auth::id());
        return redirect()->route('session-state');
    }

    // Handle login failure
}
```
**Step 3: Implement logout functionality**

In the `logout` method, clear the session state and redirect to the login page:
```php
public function logout()
{
    $this->sessionId = null;
    Session::forget('sessionId');

    // Clear session state
    Session::flush();

    // Redirect to login page
    return redirect()->route('login');
}
```
**Step 4: Test the Livewire component**

Create a new file `tests/Feature/Livewire/SessionStateTest.php` and add the following test code:
```php
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
```
These tests verify that the Livewire component handles login and logout functionality correctly, including updating and clearing the session state.