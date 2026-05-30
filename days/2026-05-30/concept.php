// File: app/Http/Controllers/ExampleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        // Use route parameter in Blade template or controller method
        return view('example.index', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function create(string $name)
    {
        // Use route parameter in controller method or Blade template
        return view('example.create', compact('name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate and save route parameter data to database or any other storage
        $id = $request->input('id');
        $name = $request->input('name');

        // Save data to database...
        return view('example.index', compact('id', 'name'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // Use route parameter in controller method or Blade template
        return view('example.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        // Use route parameter in controller method or Blade template
        return view('example.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        // Validate and save route parameter data to database or any other storage
        $name = $request->input('name');

        // Update data in database...
        return view('example.index', compact('id', 'name'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // Use route parameter in controller method or Blade template
        return view('example.destroy', compact('id'));
    }
}