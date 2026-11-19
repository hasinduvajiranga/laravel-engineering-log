// tests/Unit/Bugsnag.php

namespace Tests\Unit;

use App\Exceptions\Bugsnag;
use Illuminate\Foundation\Testing\TestCase;
use BugsnagTestCase;

class BugsnagTest extends TestCase
{
    public function testInitialize()
    {
        $bugsnag = new Bugsnag();
        $this->assertTrue($bugsnag->initialized());
    }

    public function testRender()
    {
        $e = new Throwable('Test exception');
        $response = response()->view('errors.error', ['e' => $e], 500);
        $bugsnag = new Bugsnag();
        $this->assertEquals(500, $response->status());
    }
}

// tests/Integration/Bugsnag.php

namespace Tests\Integration;

use App\Exceptions\Bugsnag;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use BugsnagTestCase;

class BugsnagTest extends BaseTestCase
{
    use WithFaker, DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->bind(Bugsnag::class, new Bugsnag());
    }

    public function testBugsnagRender()
    {
        $e = new Throwable('Test exception');
        $response = response()->view('errors.error', ['e' => $e], 500);
        $this->assertEquals(500, $response->status());
    }
}