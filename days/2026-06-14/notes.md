# Response Macros

Response macros allow you to define reusable functions that can be used to modify the HTTP response. In this example, we have created a `ResponseMacro` class with a static method called `response`.

## Usage

To use the `response` macro, simply call it on your controller or route and pass in the status code and optional message:

```php
use App\Http\Macros\ResponseMacro;

Route::get('/', function () {
    return ResponseMacro::response(200);
});
```

This will return a response with a 200 OK status code.

## Custom Messages

You can also use custom messages by passing them as the second argument to the `response` macro:

```php
use App\Http\Macros\ResponseMacro;

Route::get('/', function () {
    return ResponseMacro::response(200, 'OK');
});
```

This will return a response with a 200 OK status code and a message of "OK".

## Status Codes

You can also use custom status codes by passing them as the first argument to the `response` macro:

```php
use App\Http\Macros\ResponseMacro;

Route::get('/', function () {
    return ResponseMacro::response(404, 'Resource not found');
});
```

This will return a response with a 404 Not Found status code and a message of "Resource not found".

## Using the Macro

You can use the `response` macro to create custom responses in your controllers or routes. The macro returns an anonymous function that takes any number of arguments and returns a response object.

```php
use App\Http\Macros\ResponseMacro;

class MyController extends Controller
{
    public function index()
    {
        return ResponseMacro::response(200, 'OK');
    }
}
```

This will return a response with a 200 OK status code and a message of "OK".