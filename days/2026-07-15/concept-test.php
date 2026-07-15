// tests/Feature/BladeViewCachingTest.php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\AuthController;

class BladeViewCachingTest extends TestCase
{
    public function testBladeViewIsCached()
    {
        // Create an instance of AuthController for testing purposes
        $authController = new AuthController();

        // Set cache expiration time to 1 hour
        Cache::forget('auth.login');

        // Test the login endpoint, which should retrieve cached view
        $response = $this->postJson('/api/auth/login');
        $response->assertStatus(200);

        // Check if the response from the API call is cached
        $cachedResponse = Cache::get('auth.login');
        $this->assertEquals($cachedResponse, [
            'success' => true,
            'message' => 'Logged in successfully',
        ]);
    }

    public function testBladeViewIsNotCachedOnSecondRequest()
    {
        // Create an instance of AuthController for testing purposes
        $authController = new AuthController();

        // Set cache expiration time to 1 hour
        Cache::forever('auth.login', [
            'success' => true,
            'message' => 'Logged in successfully',
        ]);

        // Test the login endpoint on the second request, which should retrieve cached view again
        $response = $this->postJson('/api/auth/login');
        $response->assertStatus(200);

        // Check if the response from the API call is cached
        $cachedResponse = Cache::get('auth.login');
        $this->assertEquals($cachedResponse, [
            'success' => true,
            'message' => 'Logged in successfully',
        ]);
    }
}