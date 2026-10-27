// App/Http/Controllers/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([], 404);
        }
        return response()->json(['data' => $user], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create($validatedData);
        return response()->json(['data' => $user], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'sometimes|email|unique:users,email,' . $id,
        ]);

        $user->update($validatedData);
        return response()->json(['data' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 204);
    }
}