// File: app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Eloquent;

class UserController extends Controller
{
    public function index()
    {
        // Use Eloquent's 'with' method to eager load related models and compress the response.
        $users = User::with('address')->get();

        return response()->json($users, 200);
    }

    private function compressResponse(array $data): string
    {
        // Compress the data using Gzip.
        $compressedData = gzcompress(serialize($data));

        return $compressedData;
    }
}