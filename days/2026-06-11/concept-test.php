// File: tests/Http/RequestTest.php

namespace Tests\Http\Request;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Http\Requests\UserRequest;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    public function testValidate()
    {
        $request = new UserRequest([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '+1 123 456 7890',
            'password' => 'weak_password',
        ]);

        $this->assertTrue($request->validate());
    }

    public function testValidateFailEmail()
    {
        $request = new UserRequest([
            'name' => 'John Doe',
            'email' => 'invalid_email',
            'phone_number' => '+1 123 456 7890',
            'password' => 'weak_password',
        ]);

        $this->assertFalse($request->validate());
    }

    public function testValidateFailPhoneNumber()
    {
        $request = new UserRequest([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '+1 123 456 7890a', // invalid phone number
            'password' => 'weak_password',
        ]);

        $this->assertFalse($request->validate());
    }

    public function testValidateFailPassword()
    {
        $request = new UserRequest([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone_number' => '+1 123 456 7890',
            'password' => 'short_password', // password too short
        ]);

        $this->assertFalse($request->validate());
    }
}