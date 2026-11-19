// app/Exceptions/Bugsnag.php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Bugsnag;

class Bugsnag extends ExceptionHandler
{
    public function register()
    {
        Bugsnag::initialize([
            'apiKey' => env('BUGSNAG_API_KEY'),
            'projectKey' => env('BUGSNAG_PROJECT_KEY'),
        ]);
    }

    public function render($request, Throwable $e)
    {
        return view('errors.error', ['e' => $e]);
    }
}

// app/Exceptions/Error.php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Bugsnag;

class Error extends Exception
{
    public function __construct(Throwable $e)
    {
        parent::__construct($e->getMessage());
        $this->exception = $e;
    }

    public function render($request, \Illuminate\Http\Response $response)
    {
        return response()->view('errors.error', ['e' => $this->exception], 500);
    }
}