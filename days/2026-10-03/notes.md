### Eloquent Query Logging

Eloquent query logging is a useful feature for debugging and auditing purposes. It allows you to log all the queries executed by Eloquent models, which can help identify performance issues or malicious activities.

To implement Eloquent query logging in Laravel, we can use the `Log` facade provided by the framework. We'll create an `EloquentQueryLogger` service class that logs each query executed by a model.

### Loggers

We'll define two types of loggers:

*   **Basic logger**: Logs individual queries using `DB::select()` method.
*   **Eager loads logger**: Logs eager loads for models, which can help identify performance issues when using relationships between models.

```php
# EloquentQueryLogger.php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class EloquentQueryLogger
{
    public function log($query)
    {
        Log::record(['sql' => $query->toSql()], 'eloquent_queries');
    }

    public function logEagerLoads($models, $relations)
    {
        foreach ($models as $model) {
            foreach ($relations as $relation) {
                $model->load($relation);
                $this->log($model->newQuery());
            }
        }
    }
}
```

### Helper

To make logging easier, we can create a helper class called `EloquentHelper` that handles the query execution and logs the queries.

```php
# EloquentHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Services\EloquentQueryLogger;

class EloquentHelper
{
    private $logger;

    public function __construct(EloquentQueryLogger $logger)
    {
        $this->logger = $logger;
    }

    public function query($query, array $relations = [])
    {
        $models = [];
        $result = DB::table('users')->where('name', 'John Doe')->get();

        // Log the query
        $this->logger->log($DB::select('SELECT * FROM users')->toSql());

        foreach ($result as $model) {
            $models[] = $model;
        }

        if (!empty($relations)) {
            $this->logger->logEagerLoads($models, $relations);
        }

        return $models;
    }
}
```

### Example Usage

To use the `EloquentQueryLogger` service class, we can create an instance of it and call its methods to log queries:

```php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\EloquentQueryLogger;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function getLogs()
    {
        return EloquentQueryLogger::instance()->logs();
    }
}
```

By implementing Eloquent query logging in Laravel, we can gain valuable insights into the queries executed by our models and improve overall application performance.