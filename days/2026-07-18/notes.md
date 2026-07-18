# Blade i18n Integration

Blade provides a simple and expressive way to work with translations in your Laravel application. In this example, we'll explore how to integrate Blade with internationalization (i18n) capabilities.

## Setting the Locale

To use translations in Blade, you need to set the locale using the `Lang::setLocale` method. This method takes a string argument representing the new locale. You can call this method from your controllers or routes to set the locale for the entire application.

```php
use Illuminate\Support\Facades\Lang;

class TranslationController extends Controller
{
    public function store(Request $request)
    {
        Lang::setLocale($request->input('locale'));
        return redirect()->route('translation.index');
    }
}
```

## Using Translations in Blade

Once the locale is set, you can use translations in your Blade views. You can access translations using the `Lang` facade or by accessing the `__` function on your view variables.

```php
// resources/views/translation/index.blade.php

<x-greeting name="{{ Lang::get('hello') }}" />
```

In this example, we're using the `Lang::get` method to retrieve a translation for the key `'hello'`. The resulting value is then passed as the `name` attribute to the `<x-greeting>` component.

## Setting Default Locale

If you want to set a default locale for your application, you can do so by creating a middleware that sets the locale using the `Lang::setLocale` method. You can add this middleware to your kernel's `handle` method like so:

```php
// app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Kernel as HTTPKernel;
use Illuminate\Support\Facades\Lang;

class SetLocale extends HTTPKernel
{
    public function handle($request, $next)
    {
        Lang::setLocale('en'); // or any other locale you want to set as default
        return $next($request);
    }
}
```

You can then add this middleware to your kernel's `handle` method like so:

```php
// app/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HTTPKernel;
use App\Http\Middleware\SetLocale;

class Kernel extends HTTPKernel
{
    // ...

    public function handle($request, $next)
    {
        $this->pushMiddlewareToStack($request, $next);
        return $next($request);
    }

    protected $middleware = [
        SetLocale::class,
        // ...
    ];
}
```

With this middleware in place, your application will automatically set the locale to English (`'en'`) for all incoming requests.