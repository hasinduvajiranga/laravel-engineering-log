// tests/Unit/App/Providers/PrometheusExporterTest.php
namespace Tests\Unit\App\Providers;

use App\Providers\PrometheusExporter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

class PrometheusExporterTest extends TestCase
{
    use RefreshDatabase;

    public function testExporterRegistersMetrics()
    {
        Bus::assertUnreachableExceptions();

        $exporter = app(PrometheusExporter::class);

        // verify that the collector registry is registered
        $this->assertCount(1, collect($exporter)->get('prometheus.exporter')->metrics());

        // simulate a call to the User model to trigger the metric registration
        factory(User::class)->create();

        // verify that the 'users_count' metric has been created and is in the registry
        $registry = collect(app(PrometheusExporter::class))->get('prometheus.exporter')->metrics();
        $this->assertStringContainsString('getUsersCount', $registry['users_count']->name());
    }

    protected function tearDownAfterTest()
    {
        // clean up any remaining metrics from previous tests
        app(PrometheusExporter::class)->flush();
    }
}