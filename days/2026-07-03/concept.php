// app/Http/Controllers/DirectiveController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DirectiveController extends Controller
{
    /**
     * Create a new directive.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $directiveName = $request->input('name');
        $directiveContent = $request->input('content');

        // Validate input data
        $this->validate($request, [
            'name' => 'required|string',
            'content' => 'required|string',
        ]);

        // Create the directive
        $directive = new \Illuminate\Support\Str::of($directiveName);
        $directive .= " => ";
        $directive .= $directiveContent;

        return response()->json(['directive' => $directive]);
    }
}