# Eloquent Full-Text Indexing

Eloquent full-text indexing allows you to perform full-text searches on your model's fields. This is achieved by implementing the `fullTextSearch` method in your model.

**Step 1: Define the `$fillable` property**

In your model, define an array of fields that can be used for full-text searching. These fields should be the ones that you want to search for.

```php
protected $fillable = [
    'title',
    'description',
    'content'
];
```

**Step 2: Implement the `fullTextSearch` method**

Implement a `fullTextSearch` method in your model that uses Eloquent's query builder to perform the full-text search. This method should return a `Builder` instance.

```php
public function fullTextSearch(Builder $builder)
{
    return $builder->where(function ($query) {
        $query->where('title', 'like', '%' . $this->title . '%')
             ->orWhere('description', 'like', '%' . $this->title . '%')
             ->orWhere('content', 'like', '%' . $this->title . '%');
    });
}
```

**Step 3: Use the `fullTextSearch` method in your model**

Now you can use the `fullTextSearch` method to perform full-text searches on your model.

```php
$user = User::where('title', 'like', '%' . 'example' . '%')->get();
```

This will return a collection of users whose title contains the search term "example".

**Step 4: Test the `fullTextSearch` method**

Finally, you should test the `fullTextSearch` method to ensure it's working correctly.

```php
public function test_fullTextSearch()
{
    $user = User::factory()->create(['title' => 'Example Title']);

    $response = $this->get('/search', [
        'q' => 'example'
    ]);

    $response->assertSee($user->title);
}
```

This test checks that the `fullTextSearch` method returns a user whose title contains the search term "example".