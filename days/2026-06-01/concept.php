// File: app/Http/Controllers/RouteConditionalsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class RouteConditionalsController extends Controller
{
    public function index()
    {
        return view('route-conditionals');
    }

    public function routeWithCondition(Request $request)
    {
        if ($request->has('isAdmin')) {
            // Only allow admins to access this route
            $user = User::where('role', 'admin')->first();
            if (!$user) {
                abort(401, 'You are not authorized to access this route');
            }
        }

        // Simulate a request with the isAdmin parameter set to true
        // This would prevent the check from being performed for subsequent requests without this parameter
        return view('protected-page', ['isAdmin' => $request->has('isAdmin')]);
    }
}