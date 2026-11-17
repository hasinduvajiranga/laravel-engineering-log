// File: tests/Unit/Model/ErrorTest.php

namespace Tests\Unit\Model;

use App\Models\Error;
use Illuminate\Foundation\Testing\DatabaseMigrationsTestCase;

class ErrorTest extends DatabaseMigrationsTestCase
{
    public function testCreateError()
    {
        $error = new Error();
        $error->message = 'Example error message';
        $error->code = 500;
        $error->stack_trace = '...';

        $error->save();

        $this->assertEquals(1, Error::count());
    }

    public function testErrors()
    {
        $error = new Error();
        $error->message = 'Example error message';
        $error->code = 500;
        $error->stack_trace = '...';

        $error->errors()->create(['detail' => 'Error detail']);

        $this->assertCount(1, $error->errors);
    }

    public function testErrorDetail()
    {
        $error = new Error();
        $error->message = 'Example error message';
        $error->code = 500;
        $error->stack_trace = '...';

        $error->errors()->create(['detail' => 'Error detail']);

        $errorDetail = $error->errors()->first();

        $this->assertEquals('Error detail', $errorDetail->detail);
    }
}