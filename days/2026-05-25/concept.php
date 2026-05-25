// File: App/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Symfony\Component\HttpKernel\Migration;
use Symfony\Component\HttpKernel\Pipeline;
use Symfony\Component\HttpKernel\Request;

class Kernel extends HttpKernel
{
    /**
     * The application's global middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // ...
    ];

    /**
     * Define the application's route group prefixes.
     *
     * @return void
     */
    public function register()
    {
        // Register a new route group prefix
        Route::prefix('api')->group(function () {
            Route::get('/users', 'UserController@index');
            Route::get('/users/{id}', 'UserController@show');
        });

        // Register another route group prefix
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', 'DashboardController@index');
            Route::post('/new-post', 'PostController@store');
        });
    }
}