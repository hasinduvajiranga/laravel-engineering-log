// models/HealthCheck.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthCheck extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function checkUptime()
    {
        // Check if the last health check was performed within the last 10 minutes
        $lastHealthCheck = self::where('created_at', '<=', now()->subMinutes(10))->latest()->first();

        return $lastHealthCheck ? $lastHealthCheck->status : false;
    }

    public function updateUptime($status)
    {
        // Update the health check status in the database
        $this->update(['status' => $status]);
    }
}
```

```php
// app/Services/HealthCheckService.php

namespace App\Services;

use Illuminate\Support\Facades\Database;
use App\Models\HealthCheck;

class HealthCheckService
{
    public function performUptimeCheck()
    {
        // Retrieve the health check instance from the database
        $healthCheck = new HealthCheck();

        // Check if the last health check was performed within the last 10 minutes
        $status = $healthCheck->checkUptime();

        return $status;
    }

    public function updateHealthCheckStatus($status)
    {
        // Update the health check status in the database
        $healthCheck = new HealthCheck();
        $healthCheck->updateUptime($status);
    }
}
```

```php
// app/Controllers/HealthCheckController.php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Services\HealthCheckService;

class HealthCheckController extends Controller
{
    private $healthCheckService;

    public function __construct(HealthCheckService $healthCheckService)
    {
        $this->healthCheckService = $healthCheckService;
    }

    public function performUptimeCheck()
    {
        // Perform the uptime check using the health check service
        $status = $this->healthCheckService->performUptimeCheck();

        return response()->json(['uptime' => $status]);
    }
}