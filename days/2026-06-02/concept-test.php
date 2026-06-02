// File: tests/Http/CrossDomainControllerTest.php

namespace Tests\Http;

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