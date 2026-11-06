// app/Http/Controllers/FileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\FileModel; // assuming you have a model for files

class FileController extends Controller
{
    public function downloadFile(Request $request, $id)
    {
        $file = FileModel::find($id);
        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // check file type and permissions before download
        if ($file->type == 'pdf') {
            // PDFs require specific headers for download
            $headers = [
                'Content-Disposition' => 'attachment; filename="' . $file->name . '.pdf"',
                'Content-Type' => 'application/pdf',
            ];
        } elseif ($file->type == 'docx') {
            // DOCX files also have specific headers for download
            $headers = [
                'Content-Disposition' => 'attachment; filename="' . $file->name . '.docx"',
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];
        } else {
            return response()->json(['message' => 'Unsupported file type'], 400);
        }

        // generate the download link
        $downloadLink = url('/download/file/' . $id);

        return response($file->path, 200)->headers($headers);
    }
}