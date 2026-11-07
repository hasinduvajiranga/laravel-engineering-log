// app/Http/Livewire/WebhookLivewire.php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Webhook;

class WebhookLivewire extends Component
{
    public $webhookId;
    public $event;
    public $payload;

    public function mount($webhookId)
    {
        $this->webhookId = $webhookId;
        $this->loadWebhookData();
    }

    private function loadWebhookData()
    {
        $webhook = Webhook::find($this->webhookId);
        if (!$webhook) {
            abort(404, 'Webhook not found');
        }
        $this->event = $webhook->event;
        $this->payload = json_decode($webhook->payload, true);
    }

    public function handleEvent()
    {
        // Process the event payload
        echo "Received webhook event: {$this->event} with payload: ";
        print_r($this->payload);
    }
}