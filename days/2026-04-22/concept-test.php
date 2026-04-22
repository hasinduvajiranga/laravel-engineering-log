// File: tests/Unit/App/Jobs/ProcessJob.php

namespace Tests\Unit\App\Jobs;

use App\Jobs\ProcessJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProcessJobTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testProcessJob()
    {
        // Create a new job instance
        $job = new ProcessJob('Hello, World!');

        // Dispatch the job to the queue
        Queue::push($job);

        // Wait for the job to finish processing
        $this->assertDatabaseHas('emails', ['body' => 'Hello, World!']);

        // Verify that the database record was updated correctly
        $this->assertEquals(1, DB::table('records')->where('data', 'Hello, 
World!')->count());
    }

    public function testProcessJobError()
    {
        // Create a new job instance with an error
        $job = new ProcessJob('Error message');

        // Dispatch the job to the queue
        Queue::push($job);

        // Verify that the error was logged correctly
        $this->assertTrue(Logger::occurred('Error processing job'));
    }
}