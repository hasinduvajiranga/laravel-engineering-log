// File: tests/Feature/HomeControllerTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route()
    {
        $response = $this->get(route('home'));
        $response->assertViewIs('index');
    }

    public function test_dashboard_route_with_prefix()
    {
        $response = $this->get('/dashboard');
        $response->assertViewIs('dashboard');
    }

    public function test_getDashboardRouteWithPrefix()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertViewIs('dashboard');
    }
}