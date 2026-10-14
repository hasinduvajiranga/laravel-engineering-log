// app/Exceptions/ApiException.php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiException extends Exception
{
    private $code;
    private $message;
    private $errors;

    public function __construct($code, $message, $errors)
    {
        parent::__construct($message);

        $this->code = $code;
        $this->message = $message;
        $this->errors = $errors;
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

class ApplicationException extends ApiException
{
    use ApiException;

    public function __construct($code, $message, $errors)
    {
        parent::__construct($code, $message, $errors);
    }
}
```

```php
// app/Services/ErrorHandlingService.php
namespace App\Services;

use App\Exceptions\ApplicationException;
use Illuminate\Support\Facades\Log;

class ErrorHandlingService
{
    public function handleApiError(ApplicationException $exception)
    {
        if ($exception->getStatusCode() === 404) {
            return response()->json(['message' => 'Resource not found'], 404);
        } elseif ($exception->getStatusCode() === 500) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }

        $errorMessages = [];
        foreach ($exception->getErrors() as $key => $value) {
            $errorMessages[] = "Error {$key}: {$value}";
        }

        return response()->json(['errors' => $errorMessages], $exception->getStatusCode());
    }
}
```

```php
// app/Http/Controllers/ApiController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ErrorHandlingService;

class ApiController extends Controller
{
    private $errorHandlingService;

    public function __construct(ErrorHandlingService $errorHandlingService)
    {
        $this->errorHandlingService = $errorHandlingService;
    }

    public function index()
    {
        // Simulating an error
        throw new ApplicationException(404, 'Resource not found', []);
    }
}