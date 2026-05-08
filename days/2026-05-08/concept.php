// File: app/Http/Controllers/PerformanceOptimizedController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PerformanceOptimizedController extends Controller
{
    public function index()
    {
        // Using Laravel's built-in caching system to store frequently acce
accessed data
        $cachedData = Cache::get('performance_data');

        if (!$cachedData) {
            // If cache is not set, compute the data and store it in the ca
cache
            $data = $this->computePerformanceData();
            Cache::put('performance_data', $data, 3600); // Store for 1 hou
hour
        }

        return view('performance-optimized', compact('cachedData'));
    }

    private function computePerformanceData()
    {
        // Simulating a computationally expensive task
        sleep(2);

        // Using Eloquent's caching features to improve performance
        $users = User::where('id', 1)->with('orders')->get();

        return $users;
    }
}