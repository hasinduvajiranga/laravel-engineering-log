// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Cache::remember('products', 60, function () {
            return Product::all();
        });

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Cache::remember('product-' . $id, 1800, function () use 
($id) {
            return Product::find($id);
        });

        if (!$product) {
            abort(404);
        }

        return view('products.show', compact('product'));
    }
}