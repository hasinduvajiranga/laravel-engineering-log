// File: app/Http/Controllers/Admin/PerformanceOptimizationController.php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PerformanceData;

class PerformanceOptimizationController extends Controller
{
    public function index()
    {
        $performanceData = PerformanceData::where('created_at', '>=', now()
now()->subDays(30))
            ->where('updated_at', '>=', now()->subDays(30))
            ->get();

        return view('admin.performance-optimization.index', compact('perfor
compact('performanceData'));
    }

    public function optimize()
    {
        // Optimize query performance
        PerformanceData::where('created_at', '>=', now()->subDays(30))
            ->where('updated_at', '>=', now()->subDays(30))
            ->latest()
            ->get();

        // Optimize Eloquent model usage
        $performanceData = PerformanceData::all();

        return view('admin.performance-optimization.optimize', compact('per
compact('performanceData'));
    }

    public function reset()
    {
        // Reset performance data for optimization testing
        PerformanceData::truncate();
    }
}