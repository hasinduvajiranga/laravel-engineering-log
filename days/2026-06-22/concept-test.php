// tests/Http/Macros Test.php

namespace Tests\Http\Macros;

use Illuminate\Foundation\Testing\TestCase;
use App\Http\Macros\GlobalsMacro as Macro;

class GlobalsMacroTest extends TestCase
{
    public function testSuccessMacro()
    {
        $request = new \Illuminate\Http\Request();

        $response = (new Macro)->macro($request, function (\Illuminate\Http\Request $request) {
            return response()->json(['message' => 'Operation successful'], 200);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(['data' => ['test' => 'value']], $response->header('X-Response-Macro')->all());
    }

    public function testErrorMacro()
    {
        $request = new \Illuminate\Http\Request();

        $response = (new Macro)->macro($request, function (\Illuminate\Http\Request $request) {
            return response()->json(['message' => 'An error occurred'], 500, ['X-Response-Macro' => true]);
        });

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(['data' => ['test' => 'value']], $response->header('X-Response-Macro')->all());
    }

    public function testUnsupportedMacro()
    {
        $request = new \Illuminate\Http\Request();

        $response = (new Macro)->macro($request, function (\Illuminate\Http\Request $request) {
            return response()->json(['message' => 'Operation successful'], 200);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testGlobalMacro()
    {
        $request = new \Illuminate\Http\Request();

        $response = (new Macro)->macro($request, function (\Illuminate\Http\Request $request) {
            return response()->json(['message' => 'Operation successful'], 200);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals(['global' => ['test' => 'value']], $response->header('X-Response-Macro')->all());
    }
}