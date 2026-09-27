// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class User extends Model
{
    use HasAttributes;

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
```

```php
// File: app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

class Product extends Model
{
    use HasAttributes;

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected $attributes = [
        'stock_quantity' => 0,
    ];
}