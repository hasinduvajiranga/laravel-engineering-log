// File: tests/Unit/EloquentTest.php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrationsTestCase;
use Ray\Ray;

class EloquentDebuggingWithRayTest extends DatabaseMigrationsTestCase
{
    public function testEagerLoading()
    {
        $user = User::find(1);

        Ray::start();
        $posts = $user->posts()->with('user')->get();

        Ray::stop();
        self::$migrationsCount += count($posts);
    }

    public function testLazyLoading()
    {
        $user = User::find(1);

        Ray::start();
        $posts = $user->posts()->latest()->paginate(10);

        Ray::stop();
        self::$migrationsCount -= 10;
    }
}