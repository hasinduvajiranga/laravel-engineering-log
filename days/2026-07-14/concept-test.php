// File: tests/BladeAssetCompilationTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BladeAssetCompilationController;

class BladeAssetCompilationTest extends TestCase
{
    use RefreshDatabase;

    public function test_compiles_blade_assets()
    {
        // Create a new instance of the controller
        $controller = app(BladeAssetCompilationController::class);

        // Call the compileAssets method on the controller
        $response = $controller->compileAssets();

        // Verify that the asset was compiled correctly
        $this->assertTrue(file_exists(resource_path('blades/asset.compiled')));
    }
}