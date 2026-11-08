// app/EventListeners/ModelCreatedListener.php

namespace App\EventListeners;

use App\Events\ModelCreated;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelCreatedListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue;

    public function handle(ModelCreated $event)
    {
        // Perform actions when a new model is created
        \Log::info('Model created: ' . $event->model->name);

        // Trigger a cache refresh after the event
        \Cache::refresh();
    }
}