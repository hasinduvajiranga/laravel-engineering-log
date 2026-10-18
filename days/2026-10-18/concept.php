// App/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LaravelOpenApi\OpenApi\OpenApi;

class ProductController extends Controller
{
    private $openApi;

    public function __construct(OpenApi $openApi)
    {
        $this->openApi = $openApi;
    }

    public function index()
    {
        // Get products using Eloquent query
        $products = Product::all();

        // Generate OpenAPI document
        $openApiDoc = $this->openApi->generate($products);

        return response()->json(['products' => $products], 200);
    }

    public function show($id)
    {
        // Find product using Eloquent query
        $product = Product::find($id);

        if (!$product) {
            abort(404);
        }

        // Generate OpenAPI document for the single product
        $openApiDoc = $this->openApi->generateSingleProduct($product);

        return response()->json(['product' => $product], 200, ['Content-Type' => 'application/json']);
    }
}