// File: tests/Unit/Models/UserTest.php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrationsTestCase;

class UserTest extends DatabaseMigrationsTestCase
{
    public function testUserCanGenerateApiToken()
    {
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        // Generate an API token for the user
        $token = str_random(32);

        // Update the user's API tokens array with the generated token
        $user->apiTokens()->create(['token' => $token]);

        // Assert that the user has one API token
        $this->assertCount(1, $user->apiTokens());
    }

    public function testUserCanUseApiToken()
    {
        $user = new User();
        $user->name = 'Jane Doe';
        $user->email = 'jane@example.com';

        // Generate an API token for the user
        $token = str_random(32);

        // Update the user's API tokens array with the generated token
        $user->apiTokens()->create(['token' => $token]);

        // Assert that the user can use the API token to authenticate
        $this->assertTrue($user->attemptApiToken($token));
    }
}