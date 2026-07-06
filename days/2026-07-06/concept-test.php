// File: tests/Feature/TemplateControllerTest.php

namespace Tests\Feature;

use App\Http\Controllers\TemplateController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestSuite;
use Laravel\Dusk\TestCase;
use Tests\Support\Facades\View;

class TemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDefaultLayout()
    {
        $this->actingAs($this->user())
            ->get(route('template.index'))
            ->assertSee('Default Layout');
    }

    public function testCustomLayout()
    {
        $response = $this->actingAs($this->user())
            ->post(route('template.layout-change'), [
                'layout' => 'custom',
            ]);

        $view = View::make('template.index', ['layout' => 'custom']);

        $response->assertSee('Custom Layout');
    }
}