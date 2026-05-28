// app/Http/Controllers/FallbackController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FallbackController extends Controller
{
    /**
     * Handle a route fallback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        // Check if the request is for a specific route
        if ($request->route()->getRouteMethod() == 'GET') {
            return response()->json(['message' => 'Not Found']);
        }

        // If not, try to find a matching route with a default route group
        $fallbackRoute = Route::findMissing($request->input('route'), [
            'as' => null,
        ]);

        if ($fallbackRoute) {
            return redirect()->route($fallbackRoute->getRoutes()[0]);
        }

        // If no fallback route is found, return a 404 response
        return response()->json(['message' => 'Not Found'], 404);
    }
}