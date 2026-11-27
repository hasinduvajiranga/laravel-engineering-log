### Eloquent API Uptime Checks

Eloquent is a powerful ORM (Object-Relational Mapping) system in Laravel that allows you to interact with your database using PHP objects. In this example, we'll use Eloquent to implement an uptime check for our application.

**Health Check Model**

We create a `HealthCheck` model to store the health check status and last updated time. We use the `HasFactory` trait to enable factory creation for the model.

```php
// models/HealthCheck.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthCheck extends Model
{
    // ...
}
```

**Health Check Service**

We create a `HealthCheckService` class to encapsulate the business logic of performing the uptime check and updating the health check status. We use Laravel's dependency injection system to inject an instance of the model into the service.

```php
// app/Services/HealthCheckService.php

namespace App\Services;

use Illuminate\Support\Facades\Database;
use App\Models\HealthCheck;

class HealthCheckService
{
    // ...
}
```

**Health Check Controller**

We create a `HealthCheckController` class to handle incoming requests for performing the uptime check. We inject an instance of the health check service into the controller.

```php
// app/Controllers/HealthCheckController.php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Services\HealthCheckService;

class HealthCheckController extends Controller
{
    // ...
}
```

**Test**

We create a test class to verify the correctness of the health check service. We use Laravel's testing framework to write unit tests for the service.

```php
// tests/HealthCheckTest.php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\HealthCheck;
use App\Services\HealthCheckService;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    // ...
}
```

By using Eloquent and Laravel's dependency injection system, we can decouple the business logic of performing uptime checks from the model and controller layers. This makes it easier to maintain and test our application's API endpoints.

Note that this is a simplified example and you may need to adapt it to your specific use case. Additionally, you should consider implementing logging and caching mechanisms to further improve the performance and scalability of your application's uptime checks.