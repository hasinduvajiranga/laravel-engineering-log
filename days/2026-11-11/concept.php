// models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    public function getEloquentTimeout()
    {
        return config('database.timeout');
    }
}

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Set Eloquent timeout for this request
        $request->request->set('timeout', 30);

        // Find all users with the specified timeout
        $users = User::withTimeout($request->input('timeout'))->get();

        return response()->json($users, 200);
    }
}

// app/Http/Controllers/UserController.php (continued)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Set Eloquent timeout for this request
        $request->request->set('timeout', 30);

        // Find all users with the specified timeout
        $users = User::withTimeout($request->input('timeout'))->get();

        return response()->json($users, 200);
    }
}