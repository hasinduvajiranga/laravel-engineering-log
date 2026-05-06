// File: app/Http/Controllers/PerformanceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\PerformanceMetric; // Replace with your actual model

class PerformanceController extends Controller
{
    public function index()
    {
        $metrics = PerformanceMetric::all();

        if (Cache::has('performance_data')) {
            return view('performance', ['metrics' => Cache::get('performanc
Cache::get('performance_data')]);
        }

        $data = collect();
        foreach ($metrics as $metric) {
            $data->push([
                'name' => $metric->name,
                'value' => $metric->value,
            ]);
        }

        Cache::put('performance_data', $data, now()->addHours(24)); // Cach
Cache for 24 hours

        return view('performance', ['metrics' => $data]);
    }
}