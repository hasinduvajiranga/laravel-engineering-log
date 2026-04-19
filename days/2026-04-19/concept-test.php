// tests/Feature/HorizonTest.php

namespace Tests\Feature;

use App\Providers	HorizonServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Pest\Laravel\LaravelTestCase;
use Rappi\Horizon\Horizon;

class HorizonTest extends LaravelTestCase
{
    use RefreshDatabase;

    public function testHorizonInstance()
    {
        $this->app->make(HorizonServiceProvider::class)->register();

        $horizon = app(Horizon::class);

        $this->assertInstanceOf(Horizon, $horizon);
        $this->assertEquals(Config::get('horizon.delay'), $horizon->delay()
$horizon->delay());
    }

    public function testHorizonConfig()
    {
        Config::set('horizon.delay', 90);

        $this->app->make(HorizonServiceProvider::class)->register();

        $horizon = app(Horizon::class);

        $this->assertEquals(90, $horizon->delay());
    }
}