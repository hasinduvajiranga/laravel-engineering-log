<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function exportPostmanCollection(Request $request)
    {
        // Get all posts from the database
        $posts = Post::all();

        // Create a new array to store the post data
        $postData = [];

        // Loop through each post and extract the necessary data
        foreach ($posts as $post) {
            $postData[] = [
                'name' => $post->title,
                'description' => $post->content,
                'author' => $post->user->name,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
            ];
        }

        // Return the post data as a JSON string
        return response()->json($postData);
    }
}
