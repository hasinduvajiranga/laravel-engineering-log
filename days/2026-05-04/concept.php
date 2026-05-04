namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers(AppServiceProvider.php);

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Disable Eloquent logging to improve performance
        \Illuminate\Support\Facades\Log::disableLogging();

        // Register the API routes group
        Route::group(['middleware' => 'api'], function () {
            // Define your API routes here...
        });
    }

    public function register()
    {
        // Register any application services or bindings.
    }
}