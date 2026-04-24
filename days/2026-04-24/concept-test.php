// File: tests/Unit/PipelineTest.php

namespace Tests\Unit;

use App\Services\Pipeline\Pipeline;
use Illuminate\Http\Request;
use Mockery;
use Pest\LaravelTestCase;

class PipelineTest extends LaravelTestCase
{
    public function testRun()
    {
        $pipeline = new Pipeline();
        $request = Request::create('/path', 'GET');

        $step1 = Mockery::mock(Step1::class);
        $step2 = Mockery::mock(Step2::class);
        $step3 = Mockery::mock(Step3::class);

        $pipeline->addStep($step1)->addStep($step2)->addStep($step3);

        $response = $pipeline->run($request);
        $this->assertTrue($response);
    }
}