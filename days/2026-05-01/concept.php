// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        if (Cache::has('products')) {
            return response()->json(Cache::get('products'));
        }

        Cache::put('products', $products, 60);

        return response()->json($products);
    }
}