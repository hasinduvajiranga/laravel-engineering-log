// File: tests/RouteCompileTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\RouteCollection;
use Pest\Laravel\Pest;
use Pest\Laravel\Tests\TestCase;
use App\Http\RouteCompiler;

class RouteCompileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testRouteCompilerCompilesRoutes()
    {
        // Create a new route compiler instance
        $compiler = new RouteCompiler();

        // Define our routes
        $route = [
            'get' => \App\Http\Controllers\IndexController::class . '@index',
            'post' => \App\Http\Controllers\PostController::class . '@store',
        ];

        // Compile the routes using our custom compiler
        $compiler->compile($route);

        // Assert that our route is compiled correctly
        $this->assertEquals(['get' => \App\Http\Controllers\IndexController@index, 'post' => \App\Http\Controllers\PostController@store], Route::compiledRoute());
    }
}