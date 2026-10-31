// models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class User extends Model
{
    protected $cacheHeaders = ['If-Modified-Since', 'Cache-Control'];

    public function getCacheDuration()
    {
        return 60; // cache for 1 minute
    }
}

// controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('name', 'John Doe')->get();

        if ($request->hasHeader('If-None-Match')) {
            $cacheKey = Cache::makeKey($users, $request->header('If-None-Match'));
            $cachedUsers = Cache::rememberForever($cacheKey, function () use ($request) {
                return User::where('name', 'John Doe')->get();
            });

            if (Cache::has($cacheKey)) {
                return response()->json($cachedUsers, 200);
            } else {
                return response()->json(['message' => 'Not Found'], 404);
            }
        }

        $cacheKey = Cache::makeKey($users);
        $cachedUsers = Cache::rememberForever($cacheKey, function () use ($request) {
            return User::where('name', 'John Doe')->get();
        });

        return response()->json($cachedUsers, 200);
    }
}