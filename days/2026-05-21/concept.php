// File: app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Implicit Route Model Binding in action!
        $user = User::find($request->input('id'));

        return view('users.show', ['user' => $user]);
    }

    public function create()
    {
        return view('users.create');
    }
}