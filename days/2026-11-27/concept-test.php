// tests/HealthCheckTest.php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\HealthCheck;
use App\Services\HealthCheckService;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    use DatabaseMigrations;

    public function testPerformUptimeCheck()
    {
        // Create a new health check instance
        $healthCheck = HealthCheck::create(['status' => true]);

        // Perform the uptime check using the health check service
        $service = app(HealthCheckService::class);
        $this->assertEquals(true, $service->performUptimeCheck());

        // Update the health check status to false
        $service->updateHealthCheckStatus(false);

        // Perform the uptime check again
        $this->assertEquals(false, $service->performUptimeCheck());
    }
}