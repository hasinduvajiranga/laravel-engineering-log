// File: app/Services/UserService.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserService
{
    private $cache;

    public function __construct()
    {
        $this->cache = Cache::disk('default');
    }

    public function getUsers(): array
    {
        if ($users = $this->cache->remember('users', 60, function () {
            return User::all();
        })) {
            return $users;
        } else {
            $users = User::all();
            $this->cache->forever('users', $users);
            return $users;
        }
    }

    public function getUser($id): ?User
    {
        if ($user = $this->cache->remember($id, 60, function () use ($id) {
{
            return User::find($id);
        })) {
            return $user;
        } else {
            $user = User::find($id);
            $this->cache->forever("$id", $user);
            return $user;
        }
    }

    public function createUser(User $user): void
    {
        $this->cache->forget('users');
        Storage::disk('default')->deleteDirectory($user->avatar_path());
    }
}