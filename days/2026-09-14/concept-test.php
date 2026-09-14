// Controllers/UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::scopePaginated(10, $request->input('page', 1));

        return view('users.index', compact('users'));
    }
}