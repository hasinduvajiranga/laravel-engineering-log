// app/Exceptions/RestorationFailed.php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HTTPException;
use Throwable;

class RestorationFailed extends HTTPException
{
    public function __construct($message = 'The model was not restored successfully.', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
```

```php
// app/Exceptions/RestorationCompleted.php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class RestorationCompleted extends \Illuminate\Contracts\Support\Arrayable
{
    use Arrayable;

    public function toArray($only = null)
    {
        return [
            'message' => 'The model has been restored successfully.',
            'success' => true,
        ];
    }
}
```

```php
// app/Providers/EloquentRestoringServiceProvider.php

namespace App\Providers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Support\Providers\EloquentServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redis;

class EloquentRestoringServiceProvider extends ServiceProvider
{
    protected $restorationHooks = [
        'beforeRestore' => [],
        'afterRestore' => [],
    ];

    public function register()
    {
        $this->registerRestorationHooks();
    }

    private function registerRestorationHooks()
    {
        // Register restoration hooks for the `app/EloquentRestoringServiceProvider` class.
        Schema::table('restoration_log', function ($table) {
            $table->timestamps();
        });

        Log::listen(function (array $events) {
            foreach ($events as &$event) {
                if (isset($event['action']) && $event['action'] === 'beforeRestore') {
                    $this->callRestorationHooks('beforeRestore', $event);
                } elseif (isset($event['action']) && $event['action'] === 'afterRestore') {
                    $this->callRestorationHooks('afterRestore', $event);
                }
            }
        });
    }

    protected function callRestorationHooks(string $hookType, array &$event)
    {
        if (!empty($this->restorationHooks[$hookType])) {
            foreach ($this->restorationHooks[$hookType] as $callback) {
                call_user_func_array($callback, [$event]);
            }
        }
    }

    public function boot()
    {
        $this->registerRestorationEventListeners();

        // Register the model event listeners.
        ModelNotFoundException::class = new class () extends \Illuminate\Database\Eloquent\ModelNotFoundException {};
        Gate::before(function (Illuminate\Auth\GateSessionGuard $guard) {
            if ($guard->getGuard()->getUsername() === 'admin') {
                return true;
            }
            return false;
        });

        // Register the Redis connection.
        Redis::connect('localhost', 6379);
    }

    private function registerRestorationEventListeners()
    {
        // Register restoration event listeners.
        DB::listen(function ($connection, \Illuminate\Support\Collection $columns) {
            $this->emitRestorationLog($connection, $columns);
        });

        Log::warning(function (array $message) {
            return $message['log'];
        });
    }

    private function emitRestorationLog(\Illuminate\Database\ConnectionInterface $connection, \Illuminate\Support\Collection $columns)
    {
        // Emit a log event for the restoration process.
        Log::info($connection->getNamespace() . ': ' . $columns->first());
    }
}