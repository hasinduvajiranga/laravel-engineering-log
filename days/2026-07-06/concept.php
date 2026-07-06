// File: app/Http/Controllers/TemplateController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TemplateController extends Controller
{
    public function index()
    {
        return view('template.index');
    }

    public function layoutChange(Request $request)
    {
        $layout = $request->input('layout');

        if ($layout) {
            $view = View::make('template.index', ['layout' => $layout]);
        } else {
            $view = View::make('template.index');
        }

        return $view;
    }
}