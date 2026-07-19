// File: app/Http/Controllers/LayoutController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LayoutController extends Controller
{
    public function index()
    {
        // Create a layout stack with two layouts
        $layoutStack = [
            'main' => View::make('layouts.main')->with('title', 'Main Layout'),
            'nav'  => View::make('layouts.nav')->with('title', 'Navigation Bar')
        ];

        // Use the layout stack to render the view
        return View::make('pages.index', $layoutStack)->render();
    }
}