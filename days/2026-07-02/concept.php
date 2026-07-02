// File: app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Using a Blade slot to display the product details
        return view('products.show', ['product' => $product]);
    }
}

// File: resources/views/products/index.blade.php

<!-- Define a Blade slot for pagination links -->
<x-slot name="pagination">
    {{ $products->links() }}
</x-slot>

<!-- Display all products -->
<h1>All Products</h1>
<ul>
    @foreach($products as $product)
        <li>{{ $product->name }} ({{ $product->price }})
            <!-- Use the Blade scope function to display related products -->
            @scope('relatedProducts', $product->related_products()->get())
        </li>
    @endforeach
</ul>

<!-- Use a Blade scope to display related products -->
@scope('relatedProducts', function($products) {
    return view('products.related', compact('products'));
})

// File: resources/views/products/show.blade.php

<h1>{{ $product->name }}</h1>
<p>Price: {{ $product->price }}</p>

<!-- Display a Blade slot for product details -->
<x-slot name="details">
    <!-- Use the Blade scope function to display product attributes -->
    @scope('attributes', [
        'description' => $product->description,
        'weight' => $product->weight,
        // ...
    ])
</x-slot>