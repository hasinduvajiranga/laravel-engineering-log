// File: app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    protected $fillable = ['name', 'description'];

    public function attributes(): MorphMany
    {
        return $this->morphMany(ProductAttribute::class, 'product');
    }
}
```

```php
// File: app/Models/ProductAttribute.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProductAttribute extends Model
{
    protected $fillable = ['name', 'value'];

    public function product(): MorphOne
    {
        return $this->morphOne(Product::class, 'product');
    }
}
```

```php
// File: app/Models/ProductCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function attributes(): MorphMany
    {
        return $this->morphMany(ProductAttribute::class, 'product');
    }
}