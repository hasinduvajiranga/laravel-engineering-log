# Eloquent API Grafana Dashboards

Grafana provides an interface to access and manage dashboards, charts, panels, and other visualizations. In this example, we'll explore how to create a dashboard using Laravel's Eloquent ORM.

### Setting up the Database

First, let's create a database schema for our dashboards. We can use the following migration:

```php
// database/migrations/2023_03_01_000000_create_dashboards_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDashboardsTable extends Migration
{
    public function up()
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dashboards');
    }
}
```

### Creating the Dashboard Controller

Next, we'll create a dashboard controller that handles CRUD operations for our dashboards. We can use the following code:

```php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Grafana\LaravelGrafana;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $grafana;

    public function __construct(LaravelGrafana $grafana)
    {
        $this->grafana = $grafana;
    }

    public function index()
    {
        // Retrieve dashboard data from database using Eloquent
        $dashboards = DB::table('dashboards')->get();

        return view('dashboard', ['dashboards' => $dashboards]);
    }

    public function create(Request $request)
    {
        // Create a new dashboard in the database
        DB::table('dashboards')->insert([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->back();
    }
}
```

### Creating Tests

Finally, we can write tests for our dashboard controller using the following code:

```php
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
```