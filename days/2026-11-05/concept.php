// File: app/Http/Controllers/EloquentApiStreamingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class EloquentApiStreamingController extends Controller
{
    public function index()
    {
        $books = Book::where('published_date', '>=', now()->subMonths(1))
            ->take(10)
            ->get();

        return response()->json($books);
    }

    public function show(Book $book)
    {
        $this->validate($book, [
            'id' => 'required|exists:books,id',
        ]);

        return response()->json($book);
    }
}