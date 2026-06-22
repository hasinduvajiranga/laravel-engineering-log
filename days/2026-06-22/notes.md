### Response Macro Creation

Laravel provides a flexible way to create custom response macros using the `Macro` facade. A macro is a closure that can be executed before or after the response is sent.

#### Creating a Macro

To create a macro, you need to define a new class in the `App\Http\Macros` namespace. This class should extend the `Closure` class and contain the macro logic.

```php
namespace App\Http\Macros;

use Closure;
use Illuminate\Http\Request;
```

The macro should take two parameters: `$request` and `$next`. The `$request` object represents the incoming request, while the `$next` parameter is a reference to the closure that executes the response.

In the example above, we defined two macros: `GlobalsMacro` and `ResponseMacro`.

#### Using Macros

To use a macro, you can call it on the response instance using the `macro()` method. The macro will be executed before or after the response is sent, depending on the context.

```php
$response = (new Macro)->macro($request, function (\Illuminate\Http\Request $request) {
    return response()->json(['message' => 'Operation successful'], 200);
});
```

In this example, we used the `GlobalsMacro` macro to add a global meta field to the response. The `ResponseMacro` macro was used to set the content type and add a data meta field.

#### Macro Parameters

Macros can take parameters using the `$request->header()` method to access request headers or the `$request->getMacroData()` method to access macro data. These parameters can be used to customize the response based on the incoming request.

```php
if ($request->hasHeader('X-Response-Macro')) {
    $macroName = $request->header('X-Response-Macro');
    $macroData = $request->getMacroData();
}
```

#### Switching Between Macros

Macros can be switched between using the `$response->headers->set()` method to set the content type or adding meta fields.

```php
$response->headers->set('Content-Type', 'application/json');

switch ($macroName) {
    case 'success':
        return response()->json(['message' => 'Operation successful'], 200);
    case 'error':
        return response()->json(['message' => 'An error occurred'], 500, ['X-Response-Macro' => true]);
    default:
        throw new \InvalidArgumentException('Unsupported macro name');
}
```

In this example, we switched between the `success` and `error` macros based on the incoming request header.

#### Testing Macros

Macros can be tested using PHPUnit or Pest. The test code should simulate a request and verify that the response is as expected.

```php
use Tests\Http\Macros\Test;

class Test extends TestCase {
    public function testSuccessMacro()
    {
        $request = new \Illuminate\Http\Request();

        $response = (new Macro)->macro($request, function (\Illuminate\Http\Request $request) {
            return response()->json(['message' => 'Operation successful'], 200);
        });

        $this->assertEquals(200, $response->getStatusCode());
        // ...
    }
}
```

In this example, we tested the `GlobalsMacro` macro by verifying that the content type and meta fields are set correctly.