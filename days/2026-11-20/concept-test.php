// File: tests/Feature/EloquentAPIHandlerTest.php

namespace Tests\Feature;

use App\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase;
use Mockery;
use Rollbar;
use Throwable;

class EloquentAPIHandlerTest extends TestCase
{
    public function testModelNotFoundException()
    {
        Mockery::mock( rollbar()->getToken() )
            ->shouldReceive('capture')
            ->with( 'Model not found in database', 'Eloquent API Model Not Found' );

        $handler = new ExceptionHandler();

        $exception = new \Illuminate\Database\Eloquent\ModelNotFoundException;

        $result = $handler->resolveException($exception);

        self::assertEquals( Rollbar::capture( 'Model not found in database', 'Eloquent API Model Not Found' ), $result );
    }

    public function testQueryException()
    {
        Mockery::mock( rollbar()->getToken() )
            ->shouldReceive('capture')
            ->with( 'Database query failed', 'Eloquent API Query Exception' );

        $handler = new ExceptionHandler();

        $exception = new \Illuminate\Database\QueryException( 50001, 'Failed to add a row in the users table', [] );

        $result = $handler->resolveException($exception);

        self::assertEquals( Rollbar::capture( 'Database query failed', 'Eloquent API Query Exception' ), $result );
    }
}