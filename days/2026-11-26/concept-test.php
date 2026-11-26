// File: tests/Feature/Sla.php

namespace Tests\Feature;

use App\Models\Api;
use App\Models\Sla;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Date;

class SlaTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testAverageResponseTime()
    {
        // Create an API with multiple SLAs
        $api = factory(Api::class)->create();
        $sla1 = factory(Sla::class)->create(['api_id' => $api->id]);
        $sla2 = factory(Sla::class)->create(['api_id' => $api->id]);

        // Insert some data into the SLAs
        $sla1->response_time = Date::now()->addMinutes(-30);
        $sla1->save();
        $sla2->response_time = Date::now()->addHours(10);
        $sla2->save();

        // Check that the average response time is within the threshold
        $this->assertEquals($api->getAverageResponseTime(), null);

        // Update the API status to failed and check again
        $api->status = 'failed';
        $api->save();
        $this->assertEquals($api->getAverageResponseTime(), null);
    }

    public function testAverageLatency()
    {
        // Create an API with multiple SLAs
        $api = factory(Api::class)->create();
        $sla1 = factory(Sla::class)->create(['api_id' => $api->id]);
        $sla2 = factory(Sla::class)->create(['api_id' => $api->id]);

        // Insert some data into the SLAs
        $sla1->latency = Date::now()->addMinutes(-30);
        $sla1->save();
        $sla2->latency = Date::now()->addHours(10);
        $sla2->save();

        // Check that the average latency is within the threshold
        $this->assertEquals($api->getAverageLatency(), null);

        // Update the API status to failed and check again
        $api->status = 'failed';
        $api->save();
        $this->assertEquals($api->getAverageLatency(), null);
    }
}