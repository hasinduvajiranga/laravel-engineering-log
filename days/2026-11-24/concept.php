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

```php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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