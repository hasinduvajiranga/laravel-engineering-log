// File: app/Http/Controllers/CrossDomainController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class CrossDomainController extends Controller
{
    public function index()
    {
        // Handle cross-domain request using the Route facade
        $route = Route::current();
        echo "Current route: " . $route->uri() . "\n";

        return response()->json(['message' => 'Cross-domain request handled successfully.'], 200);
    }

    public function handleCrossDomainRequest(Request $request)
    {
        // Handle cross-domain request manually by setting the Access-Control-Allow-Origin header
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        return response()->json(['message' => 'Cross-domain request handled successfully.'], 200);
    }
}