// File: app/Http/Controllers/RedirectController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RedirectController extends Controller
{
    /**
     * Show the custom redirect response.
     *
     * @param  string  $url
     * @return Response
     */
    public function showCustomRedirect($url)
    {
        return response()->view('redirect', ['url' => $url], 302);
    }
}