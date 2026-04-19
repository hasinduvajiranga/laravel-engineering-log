// src/Config/Horizon.php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Rappi\Horizon\Horizon;

class HorizonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Horizon::class, function ($app) {
            return new Horizon(
                Config::get('horizon', [
                    'delay' => 60,
                    'maxRetries' => 3,
                    'maxTime' => 30,
                ]),
            );
        });
    }
}