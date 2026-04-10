<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class QueueWorkersAndSupervisorsTest extends TestCase
{
    use RefreshDatabase;

    public function testProcessUserJob()
    {
        // Create a new user
        $user = User::create(['name' => 'John Doe']);

        // Get the supervisor instance
        $supervisor = new Supervisor(Queue::dispatch(new ProcessUserJobWork
ProcessUserJobWorker()));

        // Pass the user to the job
        $supervisor->processJob($user);

        // Verify the job was processed
        $this->assertEquals(1, User::count());
    }
}