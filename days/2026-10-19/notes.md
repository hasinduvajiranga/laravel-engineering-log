### Eloquent Swagger UI Setup

The following example demonstrates how to set up the Eloquent Swagger UI in a Laravel application. The Swagger UI is a tool that generates interactive API documentation based on the OpenAPI specification.

#### Setting Up the Controller

First, create a new controller that will handle requests for the Swagger UI endpoint:
```php
// File: app/Http/Controllers/SwaggerController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Swagger\Swagger;

class SwaggerController extends Controller
{
    public function index()
    {
        $swagger = new Swagger();
        
        // Define the API endpoint
        $swagger->apiEndpoint('GET', '/api/documentation')
            ->description('Returns the Swagger UI documentation')
            ->consumes(['application/json'])
            ->produces(['application/json']);

        // Define the resource group
        $resourceGroup = [
            'title' => 'API Documentation',
            'description' => 'API documentation endpoint',
            'type' => 'object'
        ];

        // Add API resources to the resource group
        $swagger->resources([
            ['name' => 'Documentation', 'path' => '/api/documentation'],
        ]);

        // Set up the routes for the API endpoints
        Route::get('/api/documentation', [SwaggerController::class, 'index']);

        return response()->json($swagger);
    }
}
```

#### Testing the Swagger UI Endpoint

To test the Swagger UI endpoint, create a new test class that uses Pest or PHPUnit to make requests to the endpoint:
```php
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
```

#### Notes on Configuration

When setting up the Eloquent Swagger UI, make sure to configure the `swagger.json` file correctly. This file defines the API endpoints and resources that will be included in the Swagger UI documentation.

Additionally, you may need to adjust the configuration of your Laravel application to include the necessary middleware or dependencies for the Swagger UI to function properly.

By following these steps, you can set up a fully functional Eloquent Swagger UI in your Laravel application.