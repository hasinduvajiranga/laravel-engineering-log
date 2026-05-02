// File: app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function index()
    {
        $users = UserModel::where('status', 'active')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Fetch users from cache to avoid repeated queries
        $users = Cache::remember('admin.users', 60, function () {
            return UserModel::where('status', 'active')->get();
        });
        return view('admin.users.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate user input to prevent mass assignment
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            // ...
        ]);

        // Create new user instance and persist it to the database
        $user = new UserModel($validatedData);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Use
'User created successfully');
    }

    public function edit(UserModel $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, UserModel $user)
    {
        // Validate user input to prevent mass assignment
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // ...
        ]);

        // Update existing user instance and persist it to the database
        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'Use
'User updated successfully');
    }

    public function destroy(UserModel $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Use
'User deleted successfully');
    }
}