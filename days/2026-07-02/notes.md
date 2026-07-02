# Blade Slots and Scopes

Blade slots are a feature in Laravel's Blade templating engine that allows you to define reusable code blocks within your views. These blocks can be used within other views, or even dynamically generated.

Scopes are another powerful tool in Laravel that enables complex data filtering and querying using custom methods on Eloquent models. They allow you to define a set of criteria that can be applied to any model instance, making it easier to manage data across your application.

**Using Blade Slots**

To use a Blade slot, simply enclose the code within `@slot` directives in your view file. The slot name is specified within the first directive, and the content is enclosed within the second directive.

```php
<x-slot name="pagination">
    {{ $products->links() }}
</x-slot>
```

In this example, the `pagination` slot is used to display pagination links on a list of products.

**Using Scopes**

To define a scope, create a custom method on your Eloquent model. This method takes an instance of the model and returns a collection of related models that match the defined criteria.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class);
    }
}
```

In this example, the `relatedProducts` method defines a relationship between products. Any product instance that is retrieved will also have access to this scope.

**Combining Blade Slots and Scopes**

Blade slots can be used in conjunction with scopes to create more complex views that take advantage of both features. By using a Blade slot to display a section of the view, you can then use a scope to dynamically generate data for that section.

For example:

```php
<x-slot name="relatedProducts">
    @scope('relatedProducts', function($products) {
        return view('products.related', compact('products'));
    })
</x-slot>
```

In this example, the `relatedProducts` slot is used to display a list of related products. The `relatedProducts` scope is then used within that slot to dynamically generate the data for the section.

By combining Blade slots and scopes, you can create powerful and reusable views that take advantage of both features in Laravel's templating engine.