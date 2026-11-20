// File: app/Exceptions/Handler.php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->registerExceptionHandlers();
    }

    protected function resolveException(Throwable $exception): string | null
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return Rollbar::capture($exception->getMessage(), 'Eloquent API Model Not Found');
        } elseif ($exception instanceof \Illuminate\Database\QueryException && $exception->getCode() === 50001) {
            return Rollbar::capture($exception->getMessage(), 'Eloquent API Query Exception');
        }

        return parent::resolveException($exception);
    }
}