### Subdomain Routing

In this example, we'll demonstrate how to implement subdomain routing in Laravel. This feature allows you to map a specific subdomain to a particular route or controller.

**Step 1: Create the Route**

First, create a new route for your subdomain using the `get` method:
```php
Route::get('{subdomain?}', [SubdomainController::class, 'index'])->name('subdomain.index');
```
The `{subdomain?}` syntax allows you to specify an optional subdomain parameter in your URL.

**Step 2: Create the Controller**

Next, create a new controller class that will handle the requests for each subdomain:
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Route;

class SubdomainController extends Controller
{
    public function index(Request $request)
    {
        // Check if the subdomain is valid
        $subdomain = $request->get('subdomain');
        if (empty($subdomain) || !in_array($subdomain, ['blog', 'api'])) {
            return response()->json(['error' => 'Invalid subdomain'], 400);
        }

        // Handle the request based on the subdomain
        switch ($subdomain) {
            case 'blog':
                return $this->handleBlogRequest($request);
            case 'api':
                return $this->handleApiRequest($request);
            default:
                return response()->json(['error' => 'Unknown subdomain'], 404);
        }
    }

    // ...
}
```
In this example, we've created a `SubdomainController` class with an `index` method that handles requests for each subdomain.

**Step 3: Test the Route**

Finally, create test cases to verify that the route is working correctly:
```php
namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Http\Controllers(SubdomainController);
use Illuminate\Http\Request;

class SubdomainControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Route::get('{subdomain?}', [SubdomainController::class, 'index'])->name('subdomain.index');
    }

    public function testInvalidSubdomain()
    {
        $response = $this->patch('/invalid-subdomain', ['subdomain' => 'invalid']);
        $response->assertStatus(400);
        $response->assertJson(['error' => 'Invalid subdomain']);
    }

    public function testValidBlogSubdomain()
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Blog request handled successfully']);
    }

    public function testValidApiSubdomain()
    {
        $response = $this->get('/api');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'API request handled successfully']);
    }
}
```
In these tests, we're verifying that the route returns the correct response for each subdomain.