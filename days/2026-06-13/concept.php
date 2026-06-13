// File: app/Http/Validators/UserValidator.php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;
use Illuminate\Contracts\Validation\ validator;

class UserValidator extends Validator
{
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
}