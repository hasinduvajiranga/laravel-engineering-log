// tests/ViewCreators/BladeCreatorTest.php

namespace Tests\View\Creators;

use App\View\Creators\BladeCreator;
use Illuminate\Foundation\Testing\DatabaseMigrationsTestCase;
use Laravel\Laravel\Facades\View as Façade;
use Pest\Laravel\Tests\TestCase;

class BladeCreatorTest extends DatabaseMigrationsTestCase
{
    public function testCreateView()
    {
        $creator = new BladeCreator();

        $view = $creator->createView('my-view', ['title' => 'My View', 'description' => 'This is my view'], 'blade');

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('<! extends "web.layout" > <div class="container"><h1>My View</h1><p>This is my view</p></div>', (string) $view);
    }

    public function testInvalidViewName()
    {
        $creator = new BladeCreator();

        $this->expectException(\InvalidArgumentException::class);

        $creator->createView(null, [], 'blade');
    }
}