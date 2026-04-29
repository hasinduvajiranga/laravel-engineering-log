// app/Providers/HttpServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

class HttpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Enable the built-in Eloquent query builder for faster SQL querie
queries
        $this->app->make(EloquentQueryBuilder::class);

        // Use Laravel's built-in caching system (Illuminate/Cache)
        $this->app->register(CacheServiceProvider::class);
    }

    public function register()
    {
        // Register the Eloquent query builder class
        $this->app->bind(EloquentQueryBuilder::class, function ($app) {
            return new EloquentQueryBuilder($app['db']);
        });
    }
}