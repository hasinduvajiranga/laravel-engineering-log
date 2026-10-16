// In the app/Http/Kernel.php file, we need to configure CORS
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Symfony\Component\HttpKernel\Exception\ForbiddenHttpException;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These methods are called before every request to your application.
     */
    protected $middleware = [
        // ... other middleware ...
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware.
     *
     * These methods are called before every request to a given route.
     */
    protected $routeMiddleware = [
        // ... other route middleware ...
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Foundation\Http\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Support\Facades\CacheMiddleware::class,
        'can' => \App\Http\Middleware\AuthorizesRequests::class,
        'guest' => \App\Http\Middleware\AuthenticateGuest::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Foundation\Http\Middleware\ThrottleRequests::class,
    ];

    /**
     * The application's web middleware stack.
     *
     * These methods are called before every request to your application.
     */
    protected $webMiddleware = [
        // ... other web middleware ...
        \App\Http\Middleware\Cors::class,
    ];
}