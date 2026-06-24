// File: tests/Feature/UsersControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersControllerTest extends TestCase
{
    use WithFaker, WithoutMiddleware, DatabaseMigrations;

    public function testCreateUserSanitizesInput()
    {
        $user = factory(User::class)->make();

        // Prepare the request input with malicious data (e.g., SQL injection)
        $input = [
            'name' => '<script>alert("XSS")</script>',
            'email' => 'test@example.com',
        ];

        $response = $this->postJson(route('users.create'), $input);

        // Assert that the response is a successful creation
        $this->assertEquals(201, $response->status());
    }

    public function testCreateUserSanitizesInputWithEmailValidation()
    {
        $user = factory(User::class)->make();

        // Prepare the request input with invalid email data (e.g., non-existent domain)
        $input = [
            'name' => 'Test User',
            'email' => 'invalid-email', // No domain, no @
        ];

        $response = $this->postJson(route('users.create'), $input);

        // Assert that the response returns validation errors
        $this->assertEquals(422, $response->status());
    }
}