// app/Models/OrderProduct.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Model
{
    protected $table = 'order_products';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id');
    }
}

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Product extends Model
{
    protected $table = 'products';

    public function orderProducts()
    {
        return $this->belongsToMany(OrderProduct::class, 'order_products', 'product_id', 'order_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Order extends Model
{
    protected $table = 'orders';

    public function orderProducts()
    {
        return $this->belongsToMany(OrderProduct::class, 'order_products', 'order_id', 'product_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

// app/Models/EloquentPivotTable.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

abstract class EloquentPivotTable extends Model
{
    protected $fillable = [
        'pivot_table' => 'order_products',
        'columns' => ['order_id', 'product_id'],
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }
}