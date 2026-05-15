// File: app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Using caching to improve performance
        $cache = cache('users');
        if ($cache->has()) {
            return response($cache->get());
        }

        // Fetching data from the database
        $users = User::all();

        // Storing the result in the cache for 1 hour
        $cache->put('users', $users, 3600);

        return response($users);
    }
}