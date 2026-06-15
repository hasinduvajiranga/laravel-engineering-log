// tests/Feature/Controller/UserControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\UserController;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testGetJsonDataReturnsFormattedJson()
    {
        // Mock the controller's getJsonData method to return a sample response
        $this->mock(UserController::class)
            ->shouldReceive('getJsonData')
            ->andReturn(response()->json([
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ], 200));

        // Make the GET request to the controller's getJsonData method
        $response = $this->get('/users');

        // Assert that the response content is formatted JSON
        $response->assertExactJson([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        // Assert that the response contains a custom header
        $response->assertHeader('X-JSON-Format', 'timestamp:2023-02-20T14:30:00Z');
    }
}