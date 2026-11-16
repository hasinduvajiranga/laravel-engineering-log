// app/Loggers/EloquentLogger.php

namespace App\Loggers;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class EloquentLogger
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function logUpdate()
    {
        // Log the update event for all model instances
        $this->model->each(function ($instance) {
            Log::info(
                "Updated instance: {$instance->getOriginal('created_at') ?? 'N/A'} - {$instance->id}",
                ['extra' => 'Eloquent Logger']
            );
        });
    }

    public function logCreate()
    {
        // Log the created event for all model instances
        $this->model->each(function ($instance) {
            Log::info(
                "Created instance: {$instance->created_at} - {$instance->id}",
                ['extra' => 'Eloquent Logger']
            );
        });
    }

    public function logDelete()
    {
        // Log the deleted event for all model instances
        $this->model->each(function ($instance) {
            Log::info(
                "Deleted instance: {$instance->getOriginal('created_at') ?? 'N/A'} - {$instance->id}",
                ['extra' => 'Eloquent Logger']
            );
        });
    }
}