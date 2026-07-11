// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function index()
    {
        // Example data
        $user = [
            'name' => 'John Doe',
            'age' => 30,
            'is_admin' => true,
        ];

        // Render the view with conditional rendering
        return View::make('users.index', compact('user'))
            ->with([
                'isAdmin' => $user['is_admin'],
            ]);
    }
}