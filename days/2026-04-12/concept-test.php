// File: tests/Livewire/LiveStreamTest.php

namespace Tests\Livewire;

use Livewire\Livewire;
use Tests\TestCase;

class LiveStreamTest extends TestCase
{
    protected $livewire;

    public function setUp(): void
    {
        parent::setUp();

        $this->livewire = new \App\Http\Livewire\LiveStream();
    }

    public function testAuthenticateUser()
    {
        $token = 'your-auth-token';

        $response = $this->livewire->authenticateUser();

        $this->assertTrue($response['authenticated']);
        $this->assertEquals(Auth::user(), $response['user']);
    }

    public function testAuthorizeAccess()
    {
        // Authenticate user first
        $authResult = $this->livewire->authenticateUser();
        $this->assertTrue($authResult['authenticated']);

        // Authorize access for authorized user
        $response = $this->livewire->authorizeAccess();

        $this->assertTrue($response['authorized']);
    }

    public function testAuthorizeAccess_Unauthorized()
    {
        // Authenticate user first
        $authResult = $this->livewire->authenticateUser();
        $this->assertFalse($authResult['authenticated']);

        // Try to authorize access for unauthorized user
        $response = $this->livewire->authorizeAccess();

        $this->assertFalse($response['authorized']);
    }
}