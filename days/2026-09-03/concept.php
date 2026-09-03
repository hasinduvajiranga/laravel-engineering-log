// File: app/Services/JsonMutator.php

namespace App\Services;

use Illuminate\Database\Eloquent\Mutator;
use Illuminate\Support\Facades\JSON;

class JsonMutator extends Mutator
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function apply($value)
    {
        return JSON::toAscii($value);
    }
}
```

```php
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\JsonMutator;

class User extends Model
{
    use JsonMutator('json_data');

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function getJsonDataAttribute()
    {
        return json_decode($this->attributes['json_data'], true);
    }
}