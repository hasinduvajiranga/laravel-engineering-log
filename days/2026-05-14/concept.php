// File: app/Http/Controllers/PerformanceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Models\PerformanceMetric;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the performance metrics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metrics = PerformanceMetric::all();
        $cacheKey = 'performance-metrics';
        if (!Cache::has($cacheKey)) {
            $metrics = PerformanceMetric::getMetrics();
            Cache::put($cacheKey, $metrics, 60);
        }
        return view('performance.index', compact('metrics'));
    }

    /**
     * Show the form for creating a new performance metric.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create a new instance of PerformanceMetric model and save it to 
database.
        $metric = new PerformanceMetric();
        $metric->save();
        return redirect()->route('performance.index');
    }

    /**
     * Store a newly created performance metric in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate user input and create a new instance of PerformanceMetr
PerformanceMetric model.
        // Save it to database.
        $metric = new PerformanceMetric();
        $metric->save();
        return redirect()->route('performance.index');
    }

    /**
     * Display the specified performance metric.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve the specified PerformanceMetric model instance from dat
database.
        // Return it to view as response.
        $metric = PerformanceMetric::findOrFail($id);
        return view('performance.show', compact('metric'));
    }

    /**
     * Show the form for editing the specified performance metric.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Retrieve the specified PerformanceMetric model instance from dat
database.
        $metric = PerformanceMetric::findOrFail($id);
        return view('performance.edit', compact('metric'));
    }

    /**
     * Update the specified performance metric in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Retrieve the specified PerformanceMetric model instance from dat
database.
        $metric = PerformanceMetric::findOrFail($id);
        // Update it based on user input and save it to database.
        $metric->update($request->all());
        return redirect()->route('performance.index');
    }

    /**
     * Remove the specified performance metric from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Retrieve the specified PerformanceMetric model instance from dat
database.
        $metric = PerformanceMetric::findOrFail($id);
        // Delete it from database and redirect to index page.
        $metric->delete();
        return redirect()->route('performance.index');
    }
}