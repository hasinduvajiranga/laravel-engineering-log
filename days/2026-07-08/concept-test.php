// tests/BladeIncludeTest.php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithApplicationErrors;
use Illuminate\Foundation\Testing\WithoutDebugging;

class BladeIncludeTest extends TestCase
{
    use WithFaker, WithApplicationErrors, WithoutDebugging;

    public function testBladeIncludeView()
    {
        $response = $this->actingAs(User::factory()->create())->get('/include-view');
        $response->assertViewIs('include-view');
        $response->assertViewHas('message', 'Hello from include view!');
    }

    public function testBladeComponentView()
    {
        $response = $this->actingAs(User::factory()->create())->get('/component-view');
        $response->assertViewIs('component-view');
        $response->assertViewHas('message', 'Hello from component view!');
    }
}