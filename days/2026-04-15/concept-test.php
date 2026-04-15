// File: tests/Services/BatchJobServiceTest.php

namespace Tests\Services;

use App\Services\BatchJobService;
use Mockery as m;
use Illuminate\Foundation\Testing\TestCase;
use Tests\TestCase;

class BatchJobServiceTest extends TestCase
{
    public function testAddAndExecuteJobs()
    {
        $job1 = new Job();
        $job2 = new Job();

        $batchService = m::mock(BatchJobService::class);
        $batchService->shouldReceive('addJob')->once()->with(new Job());
        $batchService->shouldReceive('addJob')->once()->with(new Job());

        $batchService->execute();

        $this->assertEquals(2, count($job1->getExecutedCount()));
        $this->assertEquals(2, count($job2->getExecutedCount()));
    }
}