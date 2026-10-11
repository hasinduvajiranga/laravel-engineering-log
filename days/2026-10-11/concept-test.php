// tests/Feature/UserVersionsControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UserVersion;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithDatabase;

class UserVersionsControllerTest extends TestCase
{
    use WithFaker, WithoutMiddleware, WithDatabase;

    public function testCreateUserVersion()
    {
        $this->actingAs(\App\Models\User::factory()->create());

        $response = $this->post('/api/users/{user_id}/versions', [
            'version_number' => 1.0,
        ]);

        $response->assertStatus(200);
        $this->assertEquals(1, UserVersion::count());
    }

    public function testGetUserVersions()
    {
        $this->actingAs(\App\Models\User::factory()->create());

        // Create some user versions
        UserVersion::factory()->count(3)->create();

        $response = $this->get('/api/users/{user_id}/versions');

        $response->assertStatus(200);
        $this->assertEquals(3, response()->json('data', 200)['data']['length']);
    }
}