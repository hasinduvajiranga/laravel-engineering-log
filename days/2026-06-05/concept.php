// File: app/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Closure as ClosureClass;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        // Add route caching middleware
        \Psr\Cache\Lifecycler\FilteringAdapter::class,
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups and used within a request.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'cache' => \Psr\Cache\Lifecycler\FilteringAdapter::class,
    ];
}