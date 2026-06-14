// src/Http/Macros/ResponseMacro.php

namespace App\Http\Macros;

use Illuminate\Http\Response;
use Closure;

class ResponseMacro
{
    public static function response($statusCode, $message = null)
    {
        return (function ($callback) use ($statusCode, $message) {
            return function (...$args) use ($callback, $statusCode, $message) {
                if (!$message) {
                    $response = Response::make('Something went wrong');
                } else {
                    $response = Response::make($message);
                }

                $response->setStatusCode($statusCode);

                return $callback(...$args);
            };
        })(app());
    }
}