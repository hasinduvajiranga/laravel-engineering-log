// tests/Feature/Blade/ComponentNamespace.test.php

namespace Tests\Feature\Blade;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Behat\Facades\Behat;
use Tests\TestCase;

class BladeComponentNamespaceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_component_namespace()
    {
        $this->actingAs($this->user());

        $response = $this->get('/components');

        $response->assertViewIs('components.index');
        $response->assertViewHas('heading.title', 'Section Title');
        $response->assertViewHas('heading.level', 'h1');
        $response->assertViewHas('footer.copyright', 'Copyright 2023');
        $response->assertViewHas('footer.links.link1', ['https://example.com/link1']);
    }
}