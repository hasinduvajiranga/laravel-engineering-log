// File: app/Http/Controllers/ExampleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ExampleController extends Controller
{
    public function index()
    {
        return view('example.index');
    }

    public function store(Request $request)
    {
        // Request will be validated before being handled by this method
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        // Data is passed to the request, allowing for middleware to access it
        return view('example.store', [
            'data' => [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ],
        ]);
    }

    public function show(Request $request)
    {
        // Request will be validated before being handled by this method
        $validatedData = $request->validate([
            'id' => 'required|integer',
        ]);

        // Data is passed to the request, allowing for middleware to access it
        return view('example.show', [
            'data' => [
                'id' => $validatedData['id'],
            ],
        ]);
    }

    public function update(Request $request)
    {
        // Request will be validated before being handled by this method
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . request()->input('id') ,
        ]);

        // Data is passed to the request, allowing for middleware to access it
        return view('example.update', [
            'data' => [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ],
        ]);
    }

    public function destroy(Request $request)
    {
        // Request will be validated before being handled by this method
        $validatedData = $request->validate([
            'id' => 'required|integer',
        ]);

        // Data is passed to the request, allowing for middleware to access it
        return view('example.destroy', [
            'data' => [
                'id' => $validatedData['id'],
            ],
        ]);
    }
}