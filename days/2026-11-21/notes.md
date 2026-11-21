# Eloquent API Datadog Metrics

In this example, we'll demonstrate how to integrate Eloquent with Datadog metrics for a Laravel application. We'll create two models: `User` and `Metric`.

## User Model
The `User` model will have an `metrics` relationship that fetches all the metrics associated with a user.

```php
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function metrics()
    {
        return $this->hasMany(Metric::class, 'user_id');
    }
}
```

## Metric Model
The `Metric` model will have a `getUser` relationship that fetches the user associated with a metric.

```php
// File: app/Metrics.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datadog\DatadogLaravel\Metric;

class Metric extends Model
{
    protected $fillable = [
        'name',
        'value',
        'unit',
        'tags',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

## Integrating with Datadog
To integrate Eloquent with Datadog metrics, we'll use the `Datadog\DatadogLaravel` package. We'll install it via Composer:

```bash
composer require datadoghq/datadog-laravel
```

Then, in our `config/services.php` file, we'll add the following configuration:

```php
'providers' => [
    Datadog\DatadogLaravel\LaravelDatadogServiceProvider::class,
],
'services' => [
    'Datadog' => [
        'key' => env('DATADOG_KEY'),
        'app_id' => env('DATADOG_APP_ID'),
        'api_key' => env('DATADOG_API_KEY'),
    ],
],
```

Finally, we'll use the `Metric` model to create and update metrics with Datadog. We can do this by creating a service that wraps around Eloquent's CRUD operations:

```php
// File: app/Services/MetricService.php

namespace App\Services;

use App\Models\Metric;
use Illuminate\Support\Facades\DB;

class MetricService
{
    public function createMetric(Metric $metric)
    {
        // Create metric in database
        DB::table('metrics')->insert($metric->toArray());

        // Send data to Datadog
        Datadog\DatadogLaravel\Metric::create($metric->toArray());
    }

    public function updateMetric(Metric $metric)
    {
        // Update metric in database
        DB::table('metrics')->where('id', $metric->id)->update($metric->toArray());

        // Send updated data to Datadog
        Datadog\DatadogLaravel\Metric::update($metric->toArray());
    }
}
```

This service can be used to create and update metrics for a user:

```php
// File: app/Services/UserService.php

namespace App\Services;

use App\Models\User;
use App\Services\MetricService;

class UserService
{
    private $metricService;

    public function __construct(MetricService $metricService)
    {
        $this->metricService = $metricService;
    }

    public function createMetric(User $user, Metric $metric)
    {
        // Create metric for user
        $this->metricService->createMetric($metric);

        // Return created metric
        return $metric;
    }
}
```

This is a basic example of how to integrate Eloquent with Datadog metrics in Laravel. You can customize and extend this example to fit your specific use case.