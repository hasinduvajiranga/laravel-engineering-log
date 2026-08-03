# Eloquent Appendable Attributes

In Laravel, when you want to define a model that can have multiple instances of another model (e.g., an `Order` has many `Product`s), you can use the appendable attributes feature.

Eloquent appendable attributes allow you to create a one-to-many relationship between two models where the foreign key is not part of the model's primary key. Instead, the foreign key is stored as an attribute on the main model.

Here's how it works:

1.  The main model (e.g., `Product`) defines a method called `attributes()`, which returns a MorphMany instance representing the many-to-many relationship with another model.
2.  The other model (e.g., `ProductAttribute`) defines a method called `product()` or `morphOne()` to represent the one-to-many relationship with the main model.

To use appendable attributes, make sure you have defined the foreign key as an attribute in your Eloquent models:

```php
class Product extends Model
{
    protected $fillable = ['name', 'description', 'categories_id'];

    public function attributes(): MorphMany
    {
        return $this->morphMany(ProductAttribute::class, 'product');
    }
}
```

In the example above, we're defining a `Product` model with a foreign key called `categories_id`. We're also defining an `attributes()` method that returns a `MorphMany` instance representing the many-to-many relationship with the `ProductAttribute` model.

The `ProductAttribute` model is defined similarly:

```php
class ProductAttribute extends Model
{
    protected $fillable = ['name', 'value'];

    public function product(): MorphOne
    {
        return $this->morphOne(Product::class, 'product');
    }
}
```

When you create instances of the `ProductAttribute` model and associate them with a `Product`, you can access the related `Product` instance using the `product()` method:

```php
$product = Product::first();
$product->attributes()->create([
    'name' => 'Color',
    'value' => 'Silver',
]);
```

In this example, we're creating a new product attribute and associating it with a `Product` instance. We can then access the related `Product` instance using the `product()` method:

```php
$product->attributes()->first()->product();
```

This will return the original `Product` instance.

Note that appendable attributes are useful when you want to define relationships between models where the foreign key is not part of the model's primary key.