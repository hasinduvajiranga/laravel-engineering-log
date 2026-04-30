// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('posts')->get();
        return response()->json($users);
    }

    public function show(User $user)
    {
        // Use Laravel's eager loading feature to reduce database queries
        $user->load('posts');
        return response()->json($user);
    }
}