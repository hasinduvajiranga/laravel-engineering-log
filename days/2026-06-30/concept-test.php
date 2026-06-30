// File: test/AnonymousComponentTest.php

namespace Tests;

use App\Http\Controllers\AnonymousComponentController;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\View;
use Mockery;

class AnonymousComponentTest extends TestCase
{
    public function testAnonymousComponent()
    {
        $controller = new AnonymousComponentController();
        $component = $controller->index();

        $this->assertInstanceOf(View, $component);
        $this->assertTrue($component->hasTemplate('anonymous.component'));
    }

    public function testBladeComponent()
    {
        $controller = new BladeComponentController();
        $component = $controller->index();

        $this->assertInstanceOf(View, $component);
        $this->assertTrue($component->hasTemplate('blade.component'));
    }
}