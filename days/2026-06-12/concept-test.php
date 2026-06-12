// tests/Http/Requests/VendorRequestTest.php

namespace Tests\Http\Requests;

use Tests\TestCase;
use App\Http\Requests\VendorRequest;

class VendorRequestTest extends TestCase
{
    /**
     * Test that the authorize method returns true for authenticated users.
     *
     * @return void
     */
    public function testAuthorized()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->post('/vendors', [
            'id' => 1,
            '_method' => 'get',
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test that the authorize method returns false for unauthenticated users.
     *
     * @return void
     */
    public function testUnauthorized()
    {
        $this->post('/vendors', [
            'id' => 1,
            '_method' => 'get',
        ])->assertStatus(403);
    }

    /**
     * Test that the authorize method returns true for authorized users.
     *
     * @return void
     */
    public function testAuthorizedUser()
    {
        $user = User::factory()->create();
        $user->permissions()->attach(Vendor::factory()->create());
        $this->actingAs($user);
        $response = $this->post('/vendors', [
            'id' => 1,
            '_method' => 'get',
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test that the rules method returns an error for invalid input.
     *
     * @return void
     */
    public function testInvalidInput()
    {
        $this->post('/vendors', [
            'id' => 'abc',
            '_method' => 'get',
        ])->assertStatus(422);
    }
}