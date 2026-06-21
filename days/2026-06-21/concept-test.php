// File: tests/Http/Middleware/TestRequestMacro.php

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\RequestMacro;

class TestRequestMacro extends TestCase
{
    /**
     * @test
     */
    public function it_sets_x_macros_header()
    {
        // Create a new request instance with some sample data.
        $request = Request::json(['name' => 'John Doe', 'age' => 30]);

        // Define the middleware that adds the X-Macros header.
        $middleware = new RequestMacro();

        // Simulate the request going through the middleware by calling its handle method.
        $response = $middleware->handle($request, function () {});

        // Assert that the X-Macros header has been set correctly.
        $this->assertEquals('{"name":"John Doe","age":30}', $response->headers->get('X-Macros'));
    }
}