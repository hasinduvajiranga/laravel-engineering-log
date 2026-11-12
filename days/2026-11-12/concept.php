// File: app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        // For demonstration purposes, we'll assume there's no data for this post.
        // In a real application, you'd want to handle the case where a resource is not found.

        return response()->json(['message' => 'Resource not found'], 404);
    }
}