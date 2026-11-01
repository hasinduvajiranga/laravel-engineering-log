// tests/Http/Libraries/EloquentRequestTest.php

namespace Tests\Http\Libraries;

use App\Http\Libraries\EloquentRequest;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Request as RequestFacade;
use Mockery;

class EloquentRequestTest extends TestCase
{
    public function testMake()
    {
        $request = new EloquentRequest();

        // Perform any necessary setup or mocking for the test
        $mockRequest = Mockery::mock(Request::class);
        $mockModelClass = Mockery::mock(App\Models\MyModel::class);

        $request->make()->shouldReceive('is')
            ->withAnyValue()->andReturn(false)
            ->andReturn($mockModelClass);

        // Test that the correct model class is returned
        self::assertEquals($mockModelClass, $request->modelClass());
    }
}
```

```php
// tests/Http/Libraries/EloquentApiRequestTest.php

namespace Tests\Http\Libraries;

use App\Http\Libraries\EloquentApiRequest;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Request as RequestFacade;
use Mockery;

class EloquentApiRequestTest extends TestCase
{
    public function testMake()
    {
        $request = new EloquentApiRequest();

        // Perform any necessary setup or mocking for the test
        $mockRequest = Mockery::mock(Request::class);
        $mockCondition = Mockery::mock('Closure');

        // Set the condition for testing purposes
        $mockRequest->condition()->shouldReceive('call')
            ->withAnyValue()->andReturn(false)
            ->andReturn($mockCondition);

        $request->make()->shouldReceive('is')
            ->withAnyValue()->andReturn(true)
            ->andReturn($mockModelClass);

        // Test that the correct model class is returned
        self::assertEquals($mockModelClass, $request->modelClass());
    }
}