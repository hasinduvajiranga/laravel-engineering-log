// File: tests/Http/Livewire/ApiMonitorTest.php

namespace Tests\Http\Livewire;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\ApiCallLog;
use App\Http\Livewire\ApiMonitor;

class ApiMonitorTest extends TestCase
{
    use WithFaker;

    public function testRender()
    {
        $this->mock(ApiCallLog::findOrMakeNew()->all());
        $response = $this->actingAs($this->user())->get(route('api-monitor'));

        $response->assertViewIs('livewire.api-monitor');
        $response->assertSeeText('API Call Logs');
        $response->assertSeeText('No API call logs yet!');
    }

    public function testLogApiCall()
    {
        $request = new Request();
        $request->method = 'POST';
        $request->all(['name' => 'John Doe']);

        $this->mock(ApiCallLog::findOrMakeNew()->all());
        $response = $this->actingAs($this->user())->post(route('api-monitor.log-api-call'), ['data' => $request]);

        $response->assertRedirect('/');
        $response->assertSessionHas('message', 'API call logged successfully');
    }
}