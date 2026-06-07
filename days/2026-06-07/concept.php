// app/Http/Controllers/TestController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        // This is a simple route with a parameter
        $name = 'John Doe';
        
        return view('test.index', compact('name'));
    }

    public function show($id)
    {
        // This route expects an ID as a parameter
        $name = 'Jane Doe';
        
        return view('test.show', compact('name', 'id'));
    }
}