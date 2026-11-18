// File: app/Http/Controllers/SentryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelSentry\Sentry;

class SentryController extends Controller
{
    public function authenticate(Request $request)
    {
        // Authenticate user using Eloquent
        if (!Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Create a Sentry session for the authenticated user
        $session = Sentry::getSession();
        $session->bindUser($userId);

        // Generate an access token for the user
        $accessToken = Sentry::generateToken($userId);

        return response()->json(['token' => $accessToken]);
    }

    public function authorize(Request $request, $id)
    {
        // Retrieve the protected resource
        $resource = Resource::find($id);

        // Check if the user has permission to access the resource
        if (!$resource->canBeSeenBy(Auth::user())) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        return response()->json(['message' => 'Access granted']);
    }
}