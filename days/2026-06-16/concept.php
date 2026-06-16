// File: App/Http/Controllers/ErrorCodeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ErrorCodeController extends Controller
{
    /**
     * Display a list of error codes.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json([
            'success' => false,
            'error_codes' => [
                400 => 'Bad Request',
                401 => 'Unauthorized',
                404 => 'Not Found',
                // Add more error codes as needed
            ],
        ], 200);
    }

    /**
     * Display a specific error code.
     *
     * @param int $code
     * @return Response
     */
    public function show($code)
    {
        if (!isset($this->errorCodes[$code])) {
            abort(404, 'Error Code Not Found');
        }

        return response()->json([
            'success' => true,
            'error_code' => $code,
            'error_message' => $this->errorCodes[$code],
        ], 200);
    }

    private $errorCodes = [
        400 => 'Bad Request',
        401 => 'Unauthorized',
        404 => 'Not Found',
        // Add more error codes as needed
    ];
}