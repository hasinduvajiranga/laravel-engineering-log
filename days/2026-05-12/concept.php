// File: app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchModel;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Optimize database query using Eloquent's caching
        $search = new SearchModel();
        $search->where('keyword', $request->input('q'))
            ->cacheFor($request->input('timeout', 60) . ' minutes')
            ->get();

        return response()->json($search);
    }
}

// File: app/Models/SearchModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SearchModel extends Model
{
    protected $cachePrefix = 'search_';

    public function getQuery()
    {
        // Use Eloquent's query builder to define the database query
        return $this->select('keyword', 'description')
            ->from('keywords');
    }

    public function getCachedResults()
    {
        // Retrieve cached results from Redis
        return Cache::remember($this->cachePrefix . $this->getKey(), 60, [$
[$this, 'getQuery']);
    }
}