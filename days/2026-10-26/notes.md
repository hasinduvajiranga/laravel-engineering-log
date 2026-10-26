# Eloquent API Response Validation

When building an API that uses Eloquent models, you'll want to validate both the model's fields and any custom logic in your controller or request. This guide will help you set up a robust validation system.

### Using `Validator` for Model Rules

You can use the built-in `Validator` class provided by Laravel to define rules against your Eloquent model.

```php
// app/Http/Validators/EloquentModelValidator.php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EloquentModelValidator implements Validator
{
    // ...

    public function getRules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users,email'],
        ];
    }
}
```

### Using `Request` Validation

For custom validation logic that is not defined in the model rules, you can use a separate validator class.

```php
// app/Http/Validators/EloquentValidator.php

namespace App\Http\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class EloquentValidator implements Validator
{
    // ...

    public function validate(array $data, Request $request): bool
    {
        // Perform custom validation logic here...

        return true;
    }
}
```

### Mixing Model and Custom Rules

You can also mix model rules with custom rule logic to suit your needs.

```php
// app/Http/Controllers/EloquentApiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Validators\EloquentValidator;
use App\Http\Validators\EloquentModelValidator;

class EloquentApiController extends Controller
{
    // ...

    public function getEloquentData(Request $request): array
    {
        try {
            $data = request()->all();

            $this->validatorClass = EloquentModelValidator::class; // Validate against model rules

            $validator = Validator::make($data, (new $this->validatorClass)->getRules());
            if ($validator->fails()) {
                throw new \InvalidArgumentException('Validation failed', 0, $validator->messages());
            }

            // Perform custom validation logic here...

            return ['success' => true];
        } catch (\InvalidArgumentException $e) {
            return ['success' => false, 'error_message' => $e->getMessage()];
        }
    }
}
```

By combining model rules with custom rule logic, you can create a robust and customizable validation system that meets your API's requirements.