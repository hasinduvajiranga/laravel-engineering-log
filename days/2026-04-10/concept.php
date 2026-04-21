<?php

namespace App\Queues;

use App\Contracts\ProcessUserJob;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

class ProcessUserJobWorker implements ProcessUserJob
{
    public function process(User $user)
    {
        // Simulate some long-running job
        sleep(10);
        echo "Processed user {$user->name}".PHP_EOL;
    }
}

class Supervisor
{
    private $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function processJob(User $user)
    {
        // Start the job in a separate thread
        $job = new ProcessUserJobWorker;
        $this->queue->push($job, $user);
    }
}
