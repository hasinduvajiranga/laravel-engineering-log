// File: app/Http/Livewire/ApiMonitor.php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Laravel\ Livewire\Component;
use Illuminate\Http\Request;
use App\Models\ApiCallLog;

class ApiMonitor extends Component
{
    public $apiUrl = 'https://example.com/api';
    public $method = 'GET';
    public $data = [];

    public function render()
    {
        // Initialize API call log if it doesn't exist
        if (!$this->apiCallLogs()->exists()) {
            ApiCallLog::create([
                'url' => $this->apiUrl,
                'method' => $this->method,
                'response_time' => 0,
            ]);
        }

        // Fetch and display existing API call logs
        return view('livewire.api-monitor', [
            'logs' => $this->apiCallLogs(),
        ]);
    }

    public function logApiCall(Request $request)
    {
        $log = new ApiCallLog();
        $log->url = $this->apiUrl;
        $log->method = $request->getMethod();
        $log->data = json_encode($request->all());
        $log->response_time = time();

        // Update existing log or create a new one
        if ($this->apiCallLogs()->exists()) {
            $existingLog = $this->apiCallLogs()->first();
            $existingLog->update([
                'url' => $log->url,
                'method' => $log->method,
                'data' => $log->data,
                'response_time' => $log->response_time,
            ]);
        } else {
            $log->save();
        }

        return redirect()->back()->with('message', 'API call logged successfully');
    }

    public function apiCallLogs()
    {
        // Fetch and filter existing API call logs
        return ApiCallLog::where('url', $this->apiUrl)->get();
    }
}