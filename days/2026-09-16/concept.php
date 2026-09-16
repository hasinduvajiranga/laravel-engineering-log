// app/Http/Controllers/PaginatorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginator;
use Illuminate\Support\Facades\Paginator;

class PaginatorController extends Controller
{
    public function index(Request $request)
    {
        $models = Model::all(); // Replace with your Eloquent model

        $paginator = new LengthAwarePaginator($models, $request->input('per_page', 10), 15);
        $paginator->appends(['page' => $request->input('page', 1)]);

        return response()->view('paginator.index', compact('paginator'));
    }
}