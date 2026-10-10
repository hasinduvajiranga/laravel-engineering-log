// models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\JSON;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function toJson($format = 'json')
    {
        if ($format == 'json') {
            return JSON::toHtmlArray(json_decode($this->fresh()->toJson(), true));
        } elseif ($format == 'xml') {
            // Implement XML export logic here
            // For simplicity, we'll just use the native JSON to XML converter
            $xml = new \SimpleXMLElement('<category>' . json_encode($this->fresh()) . '</category>');
            return $xml->asXML();
        } else {
            throw new \InvalidArgumentException('Invalid format');
        }
    }
}
```

```php
// App\Http\Controllers\CategoryController.php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function exportJson()
    {
        $categories = Category::all();
        return response()->json($categories->toJson());
    }
}