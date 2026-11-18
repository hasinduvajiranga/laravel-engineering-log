// File: tests/Http/Controllers/SentryControllerTest.php

namespace Tests\Http\Controllers;

use App\Http\Controllers\SentryController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\TestCase;

class SentryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticateSuccessful()
    {
        // Mock user credentials
        $this->mockUserCredentials('user@example.com', 'password');

        // Make an authenticated request to the authenticate endpoint
        $response = $this->actingAs($this->user(), 'sentry', ['email' => 'user@example.com', 'password' => 'password'])
            ->post(route('sentry.authenticate'));

        $response->assertStatus(200);
    }

    public function testAuthenticateFailed()
    {
        // Mock user credentials
        $this->mockUserCredentials('user@example.com', 'wrong-password');

        // Make an authenticated request to the authenticate endpoint
        $response = $this->actingAs($this->user(), 'sentry', ['email' => 'user@example.com', 'password' => 'wrong-password'])
            ->post(route('sentry.authenticate'));

        $response->assertStatus(401);
    }

    public function testAuthorizeSuccessful()
    {
        // Create a protected resource
        Resource::factory()->create(['id' => 1]);

        // Make an authenticated request to the authorize endpoint with valid credentials
        $response = $this->actingAs($this->user(), 'sentry', ['email' => 'user@example.com', 'password' => 'password'])
            ->post(route('sentry.authorize'), ['id' => 1]);

        $response->assertStatus(200);
    }

    public function testAuthorizeFailed()
    {
        // Create a protected resource
        Resource::factory()->create(['id' => 1]);

        // Make an authenticated request to the authorize endpoint with invalid credentials
        $response = $this->actingAs($this->user(), 'sentry', ['email' => 'wrong-email@example.com', 'password' => 'wrong-password'])
            ->post(route('sentry.authorize'), ['id' => 1]);

        $response->assertStatus(403);
    }
}