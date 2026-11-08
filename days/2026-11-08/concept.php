// app/Event.php

namespace App\Events;

use Illuminate\Foundation\Http\Events\Event as BaseEvent;
use Illuminate\Queue\SerializesModels;

class ModelCreated extends BaseEvent
{
    use SerializesModels;

    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('events.model-created', ['model' => $this->model]);
    }
}