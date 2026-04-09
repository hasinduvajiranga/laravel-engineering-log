// File: tests/Console/Commands/HorizonConfigCommandTest.php

namespace Tests\Console\Commands;

use App\Console\Commands\HorizonConfigCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class HorizonConfigCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_configures_horizon()
    {
        $this->assertNull(Config::get('horizon'));

        (new HorizonConfigCommand)->handle();

        $this->assertEquals([
            'queue' => [
                'default' => ['job-class' => App\Jobs\MyJob::class],
            ],
        ], Config::get('horizon'));
    }
}