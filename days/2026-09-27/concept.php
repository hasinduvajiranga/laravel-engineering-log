// File: app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Get all users using raw SQL query with Eloquent
        $users = DB::table('users')->get();

        return response()->json($users);
    }

    public function show($id)
    {
        // Get a user by ID using raw SQL query with Eloquent
        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}