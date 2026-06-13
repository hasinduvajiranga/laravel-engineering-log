### Custom Request Validators

In Laravel, validators are a crucial part of the validation process. However, sometimes you may need to create custom validation logic that doesn't fit into the standard `Validator` class.

This is where a `UserValidator` comes in – it's a custom validator that extends the base `Validator` class and adds its own validation rules.

### Creating a Custom Validator

To create a custom validator, simply extend the `Validator` class and add your own validation methods. In this case, we've created a `UserValidator` class that checks for the presence of `name` and `email` fields in the request data.

```php
use Illuminate\Validation\Validator;
```

### Extending the Validator Class

To add custom validation rules to our validator, we can override the `validate()` method. This is where you'll typically put your custom validation logic.

In this case, we're checking for two things:

1.  The presence of both `name` and `email` fields.
2.  The length of the `name` field (it must be at least 2 characters long).
3.  Whether the provided email address is valid (using the `filter_var()` function).

If any of these checks fail, we'll add an error message to our `$errors` property and return `false`.

```php
public function validate(array $data): bool
{
    parent::initialize($data);

    if (!$this->validatePresenceOf('name') || !$this->validatePresenceOf('email')) {
        return false;
    }

    if (strlen($data['name']) < 2) {
        $this->errors->add('name', 'Name must be at least 2 characters long');
        return false;
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $this->errors->add('email', 'Invalid email address');
        return false;
    }

    return true;
}
```

### Testing the Custom Validator

To ensure our custom validator is working as expected, we need to create some tests for it. We'll use Pest (a Laravel testing package) in this case.

First, let's define our test class:

```php
namespace Tests\Http\Validators;

use App\Http\Validators\UserValidator;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Validator;

class UserValidatorTest extends TestCase
{
    public function testValidData()
    {
        $validator = Validator::make(['name' => 'John Doe', 'email' => 'john@example.com'], [
            'name' => 'required|min:2',
            'email' => 'required|email',
        ]);

        $this->assertTrue($validator->passes());
    }

    public function testInvalidName()
    {
        $validator = Validator::make(['name' => 'a', 'email' => 'john@example.com'], [
            'name' => 'required|min:2',
            'email' => 'required|email',
        ]);

        $this->assertFalse($validator->passes());
        $this->assertCount(1, $validator->errors()->all());
    }

    public function testInvalidEmail()
    {
        $validator = Validator::make(['name' => 'John Doe', 'email' => 'invalid'], [
            'name' => 'required|min:2',
            'email' => 'required|email',
        ]);

        $this->assertFalse($validator->passes());
        $this->assertCount(1, $validator->errors()->all());
    }
}
```

Now that we have our custom validator and its test class, let's move on to the next step – integrating it with our Laravel application.