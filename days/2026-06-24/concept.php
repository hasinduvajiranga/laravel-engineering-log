// File: app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        // Sanitize user input using Laravel's built-in validation and sanitization features
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        // Assuming we're using Eloquent, create a new user instance
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Save the user to the database
        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    }
}