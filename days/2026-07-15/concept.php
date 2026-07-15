// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Simulate a long-running operation (e.g., database query or API call)
        sleep(5);

        // Set cache expiration time to 1 hour
        Cache::forever('auth.login', $response = [
            'success' => true,
            'message' => 'Logged in successfully',
        ]);

        return response()->json($response);
    }
}