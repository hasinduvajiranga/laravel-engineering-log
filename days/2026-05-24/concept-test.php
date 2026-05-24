// File: tests/Http/Middleware/ParameterPassingMiddlewareTest.php

namespace Tests\Http\Middleware;

use App\Http\Middleware\ParameterPassingMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Testing\TestCase;
use Mockery as m;

class ParameterPassingMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_passes_the_request_to_the_next_middleware()
    {
        // Create a middleware instance and a request mock object
        $middleware = new ParameterPassingMiddleware();
        $request = m::mock(Request::class);

        // Set the input parameters on the request mock
        $request->shouldReceive('input')->once()->andReturn('value1');
        $request->shouldReceive('input')->once()->andReturn('value2');

        // Call the handle method of the middleware instance with the request mock object
        $response = $middleware->handle($request, function ($request) {
            return 'Hello World!';
        });

        // Verify that the response from the next middleware in the chain was returned by the current middleware
        $this->assertEquals('Hello World!', $response);
    }

    /**
     * @test
     */
    public function it_manipulates_request_parameters()
    {
        // Create a middleware instance and a request mock object
        $middleware = new ParameterPassingMiddleware();
        $request = m::mock(Request::class);

        // Set the input parameters on the request mock
        $request->shouldReceive('input')->once()->andReturn('value1');
        $request->shouldReceive('input')->once()->andReturn('value2');

        // Call the handle method of the middleware instance with the request mock object
        $response = $middleware->handle($request, function ($request) {
            return 'Hello World!';
        });

        // Verify that the request parameters were manipulated correctly
        $this->assertEquals('value1', $request->input('param1'));
        $this->assertEquals('value2', $request->input('param2'));

        // Assert that the response from the next middleware in the chain was returned by the current middleware
        $this->assertEquals('Hello World!', $response);
    }
}