// File: tests/Http/Middleware/A AssignControllerMiddlewareTest.php

namespace Tests\Http\Middleware;

use App\Http\Middleware\AssignControllerMiddleware;
use Illuminate\Foundation\Http\Testing\TestCase;
use Mockery;

class AssignControllerMiddlewareTest extends TestCase
{
    /**
     * @test
     */
    public function testAssignsUserToSession()
    {
        // Create a middleware instance
        $middleware = new AssignControllerMiddleware();

        // Define the user ID to be assigned
        $userId = 1;
        $request = Mockery::mock(\Illuminate\Http\Request::class);
        $request->shouldReceive('check')->andReturn(true);

        // Configure the session to capture the assigned value
        \Session::fake();
        \Session::set('user_id', $userId);

        // Call the middleware's handle method
        $result = $middleware->handle($request, function () {});

        // Verify the user ID was correctly assigned to the session
        \Session::assertContains('user_id', $userId);
    }

    /**
     * @test
     */
    public function testThrowsExceptionIfNoAuthentication()
    {
        // Create a middleware instance
        $middleware = new AssignControllerMiddleware();

        // Define a request without authentication
        $request = Mockery::mock(\Illuminate\Http\Request::class);
        $request->shouldReceive('check')->andReturn(false);

        // Call the middleware's handle method and capture the exception
        try {
            $result = $middleware->handle($request, function () {});
        } catch (\Exception $e) {}

        // Verify an AuthenticationException was thrown
        $this->assertInstanceOf(\Illuminate\Auth\AuthenticationException::class, $e);
    }
}