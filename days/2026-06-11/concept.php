// File: App/Http/Validators/UserValidator.php

namespace App\Http\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UserValidator extends Validator
{
    public function validate(array $data)
    {
        parent::validate($data);

        // Validate email
        if (!$this->isValid('email')) {
            return false;
        }

        // Validate phone number
        if (!$this->isValid('phone_number', 'regex:/^(\+?\d{1,2}\s?)?1?\-? \d{3}[\s.-]?\d{3}[\s.-]?\d{4}$/i')) {
            return false;
        }

        // Validate password length
        if (strlen($data['password']) < 8) {
            return false;
        }

        return true;
    }
}

// File: App/Http/Requests/UserRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Validators\UserValidator;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => ['required', Rule::unique('users')],
            'phone_number' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }

    protected function getValidator()
    {
        $validator = new UserValidator($this->all());
        return $validator;
    }
}