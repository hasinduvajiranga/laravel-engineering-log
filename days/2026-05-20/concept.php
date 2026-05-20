// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Route model binding has already populated the user instance with the ID 1.
        return view('users.show', compact('user'));
    }
}

// app/Http/Controllers/UpdateUserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UpdateUserController extends Controller
{
    public function update(Request $request, User $user)
    {
        // Route model binding has already populated the user instance with the ID 1.
        $user->update($request->all());
        return redirect()->route('users.index');
    }
}