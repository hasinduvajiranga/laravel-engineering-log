// File: app/Http/Controllers/BladePerformanceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class BladePerformanceController extends Controller
{
    public function index()
    {
        // Use the @forelse directive to avoid multiple blade compiles
        $data = [
            'items' => [
                ['name' => 'Item 1', 'price' => 10.99],
                ['name' => 'Item 2', 'price' => 5.99],
                ['name' => 'Item 3', 'price' => 7.99]
            ]
        ];

        return view('blade-performance', compact('data'));
    }

    public function optimizeBladePerformance()
    {
        // Use the Blade Compiler class to configure the compiler
        $compiler = new \Illuminate\Compiler\BladeCompiler;

        // Set the cache directory for compiled views
        $compiler->setCacheDirectory(public_path('views/cache'));

        // Enable compilation of CSS and JavaScript files
        $compiler->addCompiledFiles([
            'css/index.css',
            'js/script.js'
        ]);

        // Return a success message after configuration
        return 'Blade performance optimization configured successfully!';
    }
}