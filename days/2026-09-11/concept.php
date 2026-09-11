// app/Http/Controllers/PaginationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Assuming Book is a model that has pagination enabled

class PaginationController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::paginate($request->input('per_page', 10));

        return view('pagination.index', compact('books'));
    }
}