// tests/Http/Macros/ResponseMacroTest.php

namespace Tests\Http\Macros;

use App\Http\Macros\ResponseMacro;
use Illuminate\Foundation\Testing\TestCase;
use Pest\Laravel\VCRRecordTestTrait;
use VCRRecordingProxy;

class ResponseMacroTest extends TestCase
{
    use VCRRecordingProxy;

    public function testResponseMacro()
    {
        $macro = \App\Http\Macros\ResponseMacro::response(500);

        $this->mockResponse(200)
            ->shouldReceive('make')
            ->andReturn(new Response('OK', 200));

        $macro();

        $response = response()->status(500);
        $response->assertStatus(500);

        $this->assertEquals('Something went wrong', (string) $response->getContent());
    }

    public function testResponseMacro_withCustomMessage()
    {
        $macro = \App\Http\Macros\ResponseMacro::response(200, 'Custom message');

        $this->mockResponse(200)
            ->shouldReceive('make')
            ->andReturn(new Response('Custom message', 200));

        $macro();

        $response = response()->status(200);
        $response->assertStatus(200);

        $this->assertEquals('Custom message', (string) $response->getContent());
    }

    public function testResponseMacro_withStatusCode()
    {
        $macro = \App\Http\Macros\ResponseMacro::response(404, 'Resource not found');

        $this->mockResponse(404)
            ->shouldReceive('make')
            ->andReturn(new Response('Resource not found', 404));

        $macro();

        $response = response()->status(404);
        $response->assertStatus(404);

        $this->assertEquals('Resource not found', (string) $response->getContent());
    }
}