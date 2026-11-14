// App/Http/Libraries/EloquentApiHealthCheck.php

namespace App\Http\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentApiHealthCheck
{
    public function run(Request $request): array
    {
        $result = ['status' => 'ok', 'message' => '', 'errors' => []];

        // Check database connection
        try {
            DB::select('SELECT 1');
        } catch (\Exception $e) {
            $result['message'] = 'Database connection failed';
            $result['errors'][] = 'Database error: ' . $e->getMessage();
            return $result;
        }

        // Check model classes
        try {
            \App\Models\User::class;
        } catch (\Exception $e) {
            $result['message'] = 'Model classes not loaded';
            $result['errors'][] = 'Model class error: ' . $e->getMessage();
            return $result;
        }

        // Check relationships
        try {
            \App\Models\User::find(1)->address;
        } catch (\Exception $e) {
            $result['message'] = 'Relationships not loaded';
            $result['errors'][] = 'Relationship error: ' . $e->getMessage();
            return $result;
        }

        // Check cache
        try {
            \Cache::has('test');
        } catch (\Exception $e) {
            $result['message'] = 'Cache not available';
            $result['errors'][] = 'Cache error: ' . $e->getMessage();
            return $result;
        }

        return $result;
    }
}