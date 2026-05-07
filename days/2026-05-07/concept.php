// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\PerformanceOptimizer;

class UserController extends Controller
{
    private $performanceOptimizer;

    public function __construct(PerformanceOptimizer $performanceOptimizer)
$performanceOptimizer)
    {
        $this->performanceOptimizer = $performanceOptimizer;
    }

    public function index(Request $request)
    {
        // Use the performance optimizer to cache frequently accessed data
        $users = $this->performanceOptimizer->cacheUsers();

        return view('user.index', compact('users'));
    }
}