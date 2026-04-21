<?php

namespace Tests\Daily;

use App\Models\User;
use App\Queues\ProcessUserJobWorker;
use App\Queues\Supervisor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueWorkersAndSupervisorsTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_user_job()
    {
        // Create a new user
        $user = User::factory()->create(['name' => 'John Doe']);

        // Mock Queue
        Queue::fake();

        // Get the supervisor instance
        $supervisor = new Supervisor(Queue::getFacadeRoot());

        // Pass the user to the job
        $supervisor->processJob($user);

        // Verify the job was pushed
        Queue::assertPushed(ProcessUserJobWorker::class);
    }
}
