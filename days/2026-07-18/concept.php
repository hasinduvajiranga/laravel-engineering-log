// Example of a simple user model that uses Eloquent
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class User extends Model
{
    protected $fillable = ['name', 'email'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

// Example of a user controller that handles CRUD operations
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ]);
        User::create($validatedData);
        return redirect()->route('users.index');
    }
}