# Cross-Domain Route Handling

Cross-domain route handling is a crucial aspect of building scalable and maintainable web applications. When dealing with cross-origin requests (also known as CORS), we need to ensure that our server can handle requests from different domains.

## Using the Route Facade

One way to handle cross-domain requests in Laravel is by using the `Route` facade. This approach allows us to easily access the current route and get its URI.

```php
// In app/Http/Controllers/CrossDomainController.php

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class CrossDomainController extends Controller
{
    public function index()
    {
        $route = Route::current();
        echo "Current route: " . $route->uri() . "\n";

        return response()->json(['message' => 'Cross-domain request handled successfully.'], 200);
    }
}
```

## Manual Handling

However, the `Route` facade approach may not always work, especially when dealing with older browsers that do not support CORS headers.

In such cases, we can manually handle cross-domain requests by setting the necessary headers in our response. In this example, we set the `Access-Control-Allow-Origin` header to allow requests from any domain (`*`).

```php
// In app/Http/controllers/CrossDomainController.php

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CrossDomainController extends Controller
{
    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        return response()->json(['message' => 'Cross-domain request handled successfully.'], 200);
    }
}
```

## Testing

When testing cross-domain route handling, we can use the `GuzzleHttp\Client` library to simulate requests from different domains and verify that our server responds correctly.

```php
// In tests/Http/CrossDomainControllerTest.php

use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers\CrossDomainController;
use GuzzleHttp\Client;

class CrossDomainControllerTest extends TestCase
{
    public function testCrossDomainRequestHandling()
    {
        // Create a new instance of the controller and get the current route
        $controller = new CrossDomainController();
        $route = Route::current();

        // Assert that the correct route is being handled
        $this->assertEquals($route->uri(), '/cross-domain');

        // Make a request to the /cross-domain endpoint
        $response = $controller->index();

        // Assert that the response status code is 200
        $this->assertEquals(200, $response->status());

        // Check if the 'Access-Control-Allow-Origin' header is set correctly
        $client = new Client();
        $guzzleResponse = $client->get('http://example.com/cross-domain', ['headers' => ['Accept' => 'application/json']]);

        $this->assertEquals(200, $guzzleResponse->getStatusCode());
        $this->assertContains('Access-Control-Allow-Origin: *', $guzzleResponse->getHeaders()['Access-Control-Allow-Origin']);
    }

    public function testManualCrossDomainRequestHandling()
    {
        // Create a new instance of the controller
        $controller = new CrossDomainController();

        // Make a request to the /cross-domain endpoint with manual handling enabled
        $response = $controller->handleCrossDomainRequest(new Request());

        // Assert that the response status code is 200
        $this->assertEquals(200, $response->status());
    }
}
```