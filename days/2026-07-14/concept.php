// File: app/Http/Controllers/BladeAssetCompilationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\BladeCompiler;
use Illuminate\Support\Facades\Storage;

class BladeAssetCompilationController extends Controller
{
    public function compileAssets()
    {
        // Create a new instance of the Blade compiler
        $compiler = new BladeCompiler();

        // Get the compiled asset path
        $compiledAssetPath = Storage::disk('public')->path('blade-asset.compiled');

        // Compile the blade assets to the specified directory
        $compiler->compileAssetsToDirectory($compiledAssetPath);

        return response()->download($compiledAssetPath, 'blade_asset.compiled');
    }
}