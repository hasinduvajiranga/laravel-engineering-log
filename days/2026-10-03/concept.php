// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function getLogs()
    {
        return Log::records('eloquent_queries');
    }
}
```

```php
// app/Services/EloquentQueryLogger.php

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

```php
// app/Helpers/EloquentHelper.php

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

    public function query($query, array $ relations = [])
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