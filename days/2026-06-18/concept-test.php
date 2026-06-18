// File: tests/Http/ControllerTest.php

namespace Tests\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutFreshStart;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker, WithoutFreshStart;

    public function testIndex()
    {
        $controller = new Controller();
        $response = $controller->index();

        $this->assertEquals(200, $response->status());
        $this->assertEquals(['user1', 'user2'], json_decode($response->content(), true)['users']);
    }

    public function testCreate()
    {
        $controller = new Controller();
        $response = $controller->create();

        $this->assertEquals(200, $response->status());
    }
}