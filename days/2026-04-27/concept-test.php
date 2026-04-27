// File: tests/Console/Commands/HelloCommandTest.php

namespace Tests\Console\Commands;

use App\Console\Commands\HelloCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\SeleniumTestCaseTrait;

class HelloCommandTest extends TestCase
{
    use RefreshDatabase, WithFaker, SeleniumTestCaseTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHelloCommand()
    {
        $this->artisan('hello:world');
        $this->assertEquals('Hello World!', $this->output());
    }

    /**
     * Test the command is logged correctly.
     *
     * @return void
     */
    public function testLogging()
    {
        // Create a logger instance with debug level
        $logger = app(Log::class);

        $this->artisan('hello:world');

        $logger->assertLogRecordCount(Log::DEBUG, 1);
    }
}