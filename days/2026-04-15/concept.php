// File: app/Services/BatchJobService.php

namespace App\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Exception;

class BatchJobService
{
    use Queueable, SerializesModels;

    private $batchName;
    private $jobsToBatch;

    public function __construct($batchName)
    {
        $this->batchName = $batchName;
        $this->jobsToBatch = [];
    }

    public function addJob(JobInterface $job)
    {
        $this->jobsToBatch[] = $job;
    }

    public function batchJobs()
    {
        // Perform batch job
        foreach ($this->jobsToBatch as $job) {
            $job->execute();
        }
        // Clean up any temporary files
        Storage::deleteDirectory($this->batchName);
    }
}