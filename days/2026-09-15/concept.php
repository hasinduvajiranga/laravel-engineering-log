// File: app/Http/Controllers/PaginationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationController extends Controller
{
    public function index(Request $request, $models)
    {
        $limit = $request->input('per_page', 10);

        $paginator = LengthAwarePaginator::make($models, $limit, 20, null, [
            'path' => $request->input('page', 1),
            'url' => function () use ($limit) {
                return route('pagination.index', ['models' => $this->getModel(), 'per_page' => $limit]);
            }
        ]);

        return response()->json($paginator);
    }

    protected function getModel()
    {
        // Assuming we have a Model named "User"
        // Replace this with your actual model
        return \App\Models\User::all();
    }
}