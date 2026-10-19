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