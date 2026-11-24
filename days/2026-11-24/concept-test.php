// tests/Http/TestDashboardController.php

namespace Tests\Http;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Grafana\LaravelGrafanaTestCase;

class TestDashboardController extends LaravelGrafanaTestCase
{
    use DatabaseMigrations;

    public function test_index()
    {
        // Create a new dashboard in the database
        DB::table('dashboards')->insert([
            'title' => 'Test Dashboard',
            'description' => 'This is a test dashboard.',
        ]);

        // Get the dashboard data from the index method
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
    }

    public function test_create()
    {
        // Create a new request with title and description
        $request = new Request();
        $request->input('title', 'Test Dashboard');
        $request->input('description', 'This is a test dashboard.');

        // Call the create method
        $response = $this->post(route('dashboard'), $request);

        $response->assertStatus(302);
    }
}