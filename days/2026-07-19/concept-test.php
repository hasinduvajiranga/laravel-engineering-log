// File: tests/Feature/LayoutControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\TestCase;
use Tests\Support\Facades\View;

class LayoutControllerTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function test_index_view_is_rendered_correctly()
    {
        $response = $this->get('/');

        $response->assertViewIs('pages.index');
        $response->assertViewHas('title', 'Main Layout and Navigation Bar');
    }

    public function test_layout_stack_is_used_correctly()
    {
        // Create a new layout stack
        $stack = [
            'main' => View::make('layouts.main')->with('title', 'New Main Layout'),
            'nav'  => View::make('layouts.nav')->with('title', 'New Navigation Bar')
        ];

        // Use the new layout stack to render the view
        $response = $this->get('/');

        $response->assertViewIs('pages.index');
        $response->assertViewHas('title', 'New Main Layout and New Navigation Bar');
    }
}