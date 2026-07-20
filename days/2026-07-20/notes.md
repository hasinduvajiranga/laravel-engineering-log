# Eloquent Model Casting

Eloquent model casting allows you to specify how certain attributes should be cast when retrieving data from the database. This is particularly useful for handling attribute types that are not compatible with the default type.

## Defining Casting in a Model

In the `User` model, we define the `$casts` property which specifies how certain attributes should be cast:
```php
protected $casts = [
    'name' => 'string',
    'email' => 'email:full',
];
```
Here, we're casting the `name` and `email` attributes to strings and an email format respectively.

## Casting with Relationships

When using relationships in Eloquent models, you can also specify how certain attributes should be cast:
```php
public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}
```
In this case, we're not explicitly defining a casting for the `posts` relationship. However, by default, Eloquent will cast the `user_id` attribute of the related model to an integer.

## Testing Casting

When testing Eloquent models with casting, it's essential to verify that the attributes are being cast correctly:
```php
public function test_user_casting()
{
    $user = User::factory()->create();

    $this->assertEquals('John Doe', $user->name);
    $this->assertEquals('john.doe@example.com', $user->email);

    // Test the casting of the 'posts' relationship
    $posts = $user->posts;
    $this->assertCount(1, $posts);

    foreach ($posts as $post) {
        $this->assertTrue($post->user_id === $user->id);
    }
}
```
In this test, we're verifying that the `name` and `email` attributes are being cast correctly. We're also testing the casting of the `posts` relationship.

## Invalid Casting

When testing invalid casting scenarios, you can simulate attribute type mismatches:
```php
public function test_user_casting_with_invalid_type()
{
    $user = User::factory()->create();

    $user->name = ' invalid name ';
    $user->save();

    $this->assertEquals('invalid name', $user->fresh()->name);

    // Test the casting of the 'posts' relationship
    $posts = $user->posts;
    $this->assertCount(1, $posts);

    foreach ($posts as $post) {
        $this->assertTrue($post->user_id === $user->id);
    }
}
```
In this test, we're simulating a name attribute that's not a string. We're then verifying that the `name` attribute is still being cast correctly when retrieved from the database.

By following these best practices and testing scenarios, you can ensure that your Eloquent models are properly casting attributes and relationships, providing a more robust and reliable experience for your application.