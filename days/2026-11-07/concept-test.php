// tests/Http LivewireTest.php

namespace Tests\Http;

use Tests\TestCase;
use App\Http\Livewire\WebhookLivewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function testMountWebhook()
    {
        $webhook = factory(Webhook::class)->create(['event' => 'test_event', 'payload' => json_encode(['foo' => 'bar'])]);
        $this->actingAs(Auth::guest());
        $livewire = new WebhookLivewire($webhook->id);
        $livewire->mount($webhook->id);
        $this->expectViewHas('webhooks.webhook');
    }

    public function testHandleEvent()
    {
        $webhook = factory(Webhook::class)->create(['event' => 'test_event', 'payload' => json_encode(['foo' => 'bar'])]);
        $this->actingAs(Auth::guest());
        $livewire = new WebhookLivewire($webhook->id);
        $livewire->mount($webhook->id);
        $response = $livewire->handleEvent();
        $this->assertResponseOk($response);
        $this->assertEquals('Received webhook event: test_event with payload:', $response->content());
    }

    public function testHandleInvalidWebhook()
    {
        $this->actingAs(Auth::guest());
        $livewire = new WebhookLivewire(12345); // Invalid webhook ID
        $response = $livewire->mount('12345');
        $this->assertResponseNotFound($response);
    }
}