// tests/Http/ControllerTest.php
namespace Tests\Http;

use Tests\TestCase;
use App\Http\Controllers\ApiController;

class ControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(ErrorHandlingService::class);
    }

    public function testHandleApiError()
    {
        $response = $this->get('/api/endpoint');
        $response->assertStatus(404);

        $errorResponse = response()->json(['message' => 'Resource not found'], 404);
        $this->assertEquals($errorResponse->getStatusCode(), 404);
        $this->assertEquals($errorResponse->getContent(), ['message' => 'Resource not found']);
    }
}