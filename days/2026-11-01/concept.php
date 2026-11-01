// app/Http/Libraries/EloquentRequest.php

namespace App\Http\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;

class EloquentRequest extends Request
{
    protected $modelClass = null;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
    }

    public function make()
    {
        // Perform any necessary validation or checks before making the request
        // For example, we can check if the request is being made to a specific API endpoint
        if ($this->is('api.*')) {
            $this->modelClass = EloquentRequest::getModelClass();
        }

        return parent::make();
    }

    public static function getModelClass()
    {
        return App\Models\\EloquentModel::class;
    }
}
```

```php
// app/Http/Libraries/EloquentApiRequest.php

namespace App\Http\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;

class EloquentApiRequest extends Request
{
    protected $modelClass = null;
    protected $condition;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
    }

    public function make()
    {
        // Perform any necessary validation or checks before making the request
        // For example, we can check if the request is being made to a specific API endpoint and pass the condition
        if ($this->is('api.*') && $this->condition) {
            $this->modelClass = EloquentApiRequest::getModelClass();
        }

        return parent::make();
    }

    public static function getModelClass()
    {
        return App\Models\\EloquentModel::class;
    }
}
```

```php
// app/Http/Controllers/EloquentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libraries\EloquentRequest;
use App\Http\Libraries\EloquentApiRequest;

class EloquentController extends Controller
{
    public function index(EloquentRequest $request)
    {
        // Perform any necessary logic based on the model class and condition
        $model = $request->modelClass();

        if ($request->condition()) {
            // Only perform certain actions when the condition is met
            $model->action();
        }

        return response()->json($model);
    }
}