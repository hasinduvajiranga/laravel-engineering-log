// FileUploader.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploader extends Controller
{
    /**
     * Store a newly uploaded file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'file' => 'required|file|max:2048',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Store the file in public storage
        Storage::disk('public')->putFileAs('uploads', $file, time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension());

        // Return a success response with the uploaded file's URL
        return response()->json(['url' => url('uploads/' . $file->getClientOriginalName())]);
    }
}