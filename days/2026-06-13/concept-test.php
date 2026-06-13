// File: tests/Http/Validators/UserValidatorTest.php

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