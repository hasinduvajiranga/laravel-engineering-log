// Test the CreateRouteMacro class using Pest
use App\Http\Routes\Macros\CreateRouteMacro;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

test('create route macro', function (Illuminate\Foundation\Application $app) {
    // Set up the router
    $router = $app->make(RouteServiceProvider::class);

    // Create a new instance of the CreateRouteMacro class
    $macro = new CreateRouteMacro();

    // Use the createRouteMacro method to create a route
    $route = $macro->createRouteMacro('test', '/test', function () {
        return response()->json(['message' => 'Test message']);
    });

    // Assert that the route exists
    $this->assertEquals(200, Route::get('/test')->ensburg());

    // Assert that the middleware is set to 'api'
    $this->assertTrue(Route::get('/test')->middleware()->contains('api'));
});