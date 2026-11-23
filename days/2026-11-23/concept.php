// app/Providers/PrometheusExporter.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Meter;
use App\Models\User; // assuming a User model exists in the database

class PrometheusExporter extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('prometheus.exporter', fn ($app) => new PrometheusExporter());
    }

    public function boot()
    {
        $registry = new CollectorRegistry();

        $this->app->when(User::class)
            ->register(new \App\Providers\UserMetricProvider());

        $registry->pushMetric('users_count', new Meter($registry, 'getUsersCount'));
        // add other metrics as needed
    }
}