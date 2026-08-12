# Eloquent HasManyThrough Relationships

Eloquent's `hasManyThrough` method allows you to establish a relationship between two models, where the first model has many instances of the second model. The relationship is created through an intermediate table.

In our example, we have three models: `User`, `Post`, and `PostComment`. We want to create a one-to-many relationship between `User` and `Post` (through the comments), and another one-to-many relationship between `Post` and `User` (through the comments).

To achieve this, we use the following code:

```php
public function posts()
{
    return $this->hasManyThrough(Post::class, PostComment::class, 'user_id', 'post_comment_user_id');
}

public function comments()
{
    return $this->hasManyThrough(PostComment::class, User::class, 'post_id', 'user_id');
}
```

In the `User` model, we use `$this->hasManyThrough` to create a relationship between the user and the post (through the comment). The first argument is the related model (`Post::class`), the second argument is the intermediate table (`PostComment::class`), the third argument is the foreign key on the first model (`'user_id'`), and the fourth argument is the foreign key on the intermediate table (`'post_comment_user_id'`).

Similarly, in the `Post` model, we use `$this->hasManyThrough` to create a relationship between the post and the user (through the comment). The arguments are similar to those used in the previous example.

With these relationships established, we can access the related models using the dot notation. For example:

```php
$user = User::factory()->create();
$post = Post::factory()->create(['user_id' => $user->id]);

// Get all posts for a user
$posts = $user->posts;

// Get all comments for a post
$comments = $post->comments;
```

Note that the `hasManyThrough` relationship is not available on the intermediate table (`PostComment`). Instead, we access the related models using the dot notation.