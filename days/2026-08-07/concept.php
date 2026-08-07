// File: app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Eloquent;
use App\Models\SearchableModel;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $model = new SearchableModel();
        $query = $request->input('q');

        if ($query) {
            $searchResults = $model->whereHas('translatable', function ($query) use ($query) {
                $query->select('id', 'name')
                      ->from($model->getTable())
                      ->where('name', 'like', '%' . $query . '%');
            });

            return view('search.index', compact('searchResults'));
        }

        return view('search.index');
    }
}