// File: tests/Http/KernelTest.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KernelTest extends TestCase
{
    use RefreshDatabase;

    public function test_caching_middleware_is_added()
    {
        $kernel = app(Kernel::class);
        $this->assertArrayHasKey('cache', $kernel->middleware);
    }

    /**
     * @test
     */
    public function it_calls_the_cache_filtering_adapter_method_on_request()
    {
        $kernel = app(Kernel::class);

        $kernel->callFor($kernel->routeMiddleware['cache']);

        // Assert that the call was made to the correct method
        // This will depend on the implementation of your cache filter
        // For example, if it's a simple cache filter
        $this->assertMethodCalled('filter', 'Psr\Cache\Lifecycler\FilteringAdapter');
    }
}