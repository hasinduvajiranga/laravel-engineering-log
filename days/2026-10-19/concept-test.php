// File: tests/HttpTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Tests\TestCase;

class HttpTest extends TestCase
{
    use DatabaseMigrations;

    public function testSwaggerControllerReturnsCorrectResponse()
    {
        // Create a new instance of the Swagger controller
        $swaggerController = app(SwaggerController::class);

        // Make a GET request to the API endpoint
        $response = $this->get('/api/documentation');

        // Assert that the response is in JSON format and contains the expected data
        $this->assertResponseJsonConforming($response, [
            'swagger' => '2.0',
            'info' => [
                'title' => 'API Documentation',
                'description' => null,
                'version' => null,
            ],
            // Add more properties to assert as needed
        ]);
    }
}