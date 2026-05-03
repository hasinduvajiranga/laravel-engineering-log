// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Using Eager Loading to improve performance
        $users = User::with('posts')->get();
        
        return view('users.index', compact('users'));
    }
    
    public function show(User $user)
    {
        // Using Relationship Caching to reduce database queries
        $user->load('posts');
        
        return view('user.show', compact('user'));
    }
}