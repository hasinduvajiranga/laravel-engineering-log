// File: app/Http/Controllers/JsonQueryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class JsonQueryController extends Controller
{
    public function index()
    {
        $books = Book::select('id', 'title', 'author')->get();

        return response()->json($books);
    }

    public function jsonQuery(Request $request)
    {
        $query = $request->input('query');

        $results = Book::whereJsonExists('description', ['search query'])
            ->orWhereJsonContains('tags', ['query'])
            ->get();

        return response()->json(['results' => $results]);
    }
}