// tests/HttpServiceProviderTest.php

namespace Tests\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use App\Providers\HttpServiceProvider;
use Illuminate\Support\Facades\Cache;

class HttpServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Disable Eloquent query builder caching to test its effect
        $this->app['http']->make('EloquentQueryBuilder')->disable();

        // Reset cache before each test
        Cache::clear();
    }

    public function testHttpServiceProviderBoot()
    {
        $this->assertTrue($this->app['http']->make(EloquentQueryBuilder::cl
$this->assertTrue($this->app['http']->make(EloquentQueryBuilder::class)->en$this->assertTrue($this->app['http']->make(EloquentQueryBuilder::clss)->enabled());
        $this->assertEquals(false, $this->app['http']->make(EloquentQueryBu
$this->app['http']->make(EloquentQueryBuilder::class)->isEnabled());
    }
}