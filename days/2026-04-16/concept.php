// src/Database/TransactionExample.php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionExample extends Model
{
    protected $fillable = ['name', 'email'];

    public function create()
    {
        DB::transaction(function () {
            // Simulate a scenario where we're creating two dependent model
models.
            $user = new self(['name' => 'John Doe', 'email' => 'john@exampl
'john@example.com']);
            $post = new Post(['title' => 'My First Post', 'content' => 'Thi
'This is my first post.', 'user_id' => 1]);

            // Insert the user and post into the database.
            $user->save();
            $post->save();

            // Return the newly created user and post IDs.
            return [$user->id, $post->id];
        });
    }
}

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    public function create()
    {
        DB::transaction(function () {
            $this->title = 'My Second Post';
            $this->content = 'This is my second post.';
            $this->user_id = 1;
            $this->save();

            // Return the newly created post ID.
            return $this->id;
        });
    }
}