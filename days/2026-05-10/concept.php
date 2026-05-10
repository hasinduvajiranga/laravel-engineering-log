// File: app/Http/Controllers/PerformanceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerformanceMetric;

class PerformanceController extends Controller
{
    public function index()
    {
        // Fetch performance metrics from the database and cache them for 1
1 hour
        $metrics = PerformanceMetric::where('timestamp', '<=', now()->subHo
now()->subHour)->get();
        Cache::put('performance_metrics', $metrics, 3600); // Cache for 1 h
hour

        return view('performance', ['metrics' => $metrics]);
    }

    public function optimize()
    {
        // Optimize database queries by using eager loading
        $metrics = PerformanceMetric::with('relatedMetric')->get();

        return view('optimize_performance', ['metrics' => $metrics]);
    }
}