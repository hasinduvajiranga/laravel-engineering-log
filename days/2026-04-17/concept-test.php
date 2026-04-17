// File: tests/ValidationTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use App\Tests\TestCase;
use App\Macros\Validator as ValidatorMacro;

class ValidationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testValidateUsingMacro()
    {
        $this->assertEquals(0, (function () { Validator::make(['test' => 't
'test'], ['test' => 'required'])->fails(); })());

        $validator = (function () {
            return Validator::make(['test' => 'test'], [
                'test' => 'required',
                'foo' => Str::random(10),
            ])->validate();
        })();

        // Validate should throw an exception here
        $this->expectException(ValidationException::class);
    }
}