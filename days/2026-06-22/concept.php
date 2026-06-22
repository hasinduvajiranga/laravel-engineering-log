// src/Http/Macro.php

namespace App\Http\Macros;

use Illuminate\Http\Request;
use Closure;

class ResponseMacro
{
    public static function macro(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->hasHeader('X-Response-Macro')) {
            $macroName = $request->header('X-Response-Macro');
            $macroData = $request->getMacroData();

            $response->headers->set('Content-Type', 'application/json');

            switch ($macroName) {
                case 'success':
                    return response()->json(['message' => 'Operation successful'], 200);
                case 'error':
                    return response()->json(['message' => 'An error occurred'], 500, ['X-Response-Macro' => true]);
                default:
                    throw new \InvalidArgumentException('Unsupported macro name');
            }
        }

        return $response;
    }
}
```

```php
// src/Http/Macros/Globals.php

namespace App\Http\Macros;

use Closure;

class GlobalsMacro
{
    public static function macro(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->hasHeader('X-Response-Macro')) {
            $macroName = $request->header('X-Response-Macro');
            $macroData = $request->getMacroData();

            $response->withMeta('data', $macroData);
            $response->headers->set('Content-Type', 'application/json');

            switch ($macroName) {
                case 'success':
                    return response()->json(['message' => 'Operation successful'], 200);
                case 'error':
                    return response()->json(['message' => 'An error occurred'], 500, ['X-Response-Macro' => true]);
                default:
                    throw new \InvalidArgumentException('Unsupported macro name');
            }
        }

        $response->withMeta('global', ['test' => 'value']);

        return $response;
    }
}