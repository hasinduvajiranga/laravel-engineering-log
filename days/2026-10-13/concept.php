// Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

// App/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate($request->input('per_page', 10));

        return response()->json([
            'data' => $users,
            'meta' => [
                'current_page' => $users->currentPage(),
                'total_pages' => $users-> totalPages(),
                'per_page' => $users->perPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ],
        ]);
    }
}

// App/Http/Controllers/UserController.php (continued)
public function show(User $user)
{
    return response()->json($user);
}