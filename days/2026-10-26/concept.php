// app/Http/Validators/EloquentValidator.php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class EloquentValidator implements Validator
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function withRequest(Request $request): array
    {
        return [];
    }

    public function validate(array $data, Request $request): bool
    {
        $validator = parent::validate($data, $request);

        if ($validator->fails()) {
            throw new \InvalidArgumentException('Validation failed', 0, $validator->messages());
        }

        // Perform additional Eloquent model validation logic here
        return true;
    }
}
```

```php
// app/Http/Validators/EloquentModelValidator.php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EloquentModelValidator implements Validator
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function withRequest(Request $request): array
    {
        return [];
    }

    public function validate(array $data, Request $request): bool
    {
        // Perform standard Eloquent model validation logic here
        $validator = Validator::make($data, (new $this->model)->$this->model->getRules());

        if ($validator->fails()) {
            throw new \InvalidArgumentException('Validation failed', 0, $validator->messages());
        }

        return true;
    }
}
```

```php
// app/Http/Controllers/EloquentApiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Validators\EloquentValidator;
use App\Http\Validators\EloquentModelValidator;

class EloquentApiController extends Controller
{
    protected $validatorClass = EloquentValidator::class;

    public function __construct()
    {
        parent::__construct();

        $this->validatorClass = EloquentModelValidator::class; // Or use this if you want to validate against the model's rules
    }

    public function getEloquentData(Request $request): array
    {
        try {
            $data = request()->all(); // Assume 'all' is used for GET requests, modify as needed

            $this->validatorClass::validate($data, $request);

            // Perform your Eloquent model logic here...

            return ['success' => true];
        } catch (\InvalidArgumentException $e) {
            return ['success' => false, 'error_message' => $e->getMessage()];
        }
    }

    public function getEloquentModelData(Model $model): array
    {
        try {
            // Assume you're using Eloquent to fetch data from the database...

            return ['data' => $model];
        } catch (\Exception $e) {
            return ['success' => false, 'error_message' => $e->getMessage()];
        }
    }

    public function getEloquentModelValidationRules(Model $model): array
    {
        return (new $this->validatorClass)->getRules();
    }
}