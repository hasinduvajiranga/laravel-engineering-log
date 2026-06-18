// File: app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private $userService;
    private $userRepository;

    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('users.index', [
            'users' => $this->userRepository->all(),
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    // other methods...
}

class UserService
{
    public function getAllUsers()
    {
        // logic to get all users from the database or API
        return ['user1', 'user2'];
    }
}

class UserRepository
{
    public function all()
    {
        // logic to retrieve all users from the database
        return [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Doe'],
        ];
    }
}