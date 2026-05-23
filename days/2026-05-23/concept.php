// File: app/Http/Controllers/CachedController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CachedController extends Controller
{
    public function index()
    {
        // If the route is cached, return the cached response
        if (Route::is('cached.index')) {
            $response = cache()->get('cached.index');
            if ($response !== false) {
                return $response;
            }
        }

        // Otherwise, calculate and store the response in the cache
        $data = 'This is a cached route response';
        $response = '<h1>' . $data . '</h1>';

        // Store the response in the cache with a TTL of 1 day
        cache()->put('cached.index', $response, now()->addDay());

        return $response;
    }
}