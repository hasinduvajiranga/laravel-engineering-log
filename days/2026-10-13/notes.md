# Eloquent Pagination in APIs

Eloquent pagination is a common requirement in many Laravel applications, especially when building APIs. It allows you to fetch a subset of records from the database, along with metadata such as current page, total pages, per-page count, and item range.

In this example, we will demonstrate how to implement Eloquent pagination in our API using Laravel's built-in `paginate` method on the `User` model.

### User Model

Firstly, let's modify our `User` model to include pagination metadata:

```php
public function getPaginatedItems()
{
    return $this->posts()->paginate();
}
```

Then, we will create a new API endpoint in our `UserController` to fetch paginated users:

```php
public function index(Request $request)
{
    $users = User::paginate($request->input('per_page', 10));

    return response()->json([
        'data' => $users,
        'meta' => [
            'current_page' => $users->currentPage(),
            'total_pages' => $users-> totalPages(),
            'per_page' => $users->perPage(),
            'from' => $users->firstItem(),
            'to' => $users->lastItem(),
        ],
    ]);
}
```

### API Endpoint

We can now call the `index` endpoint on our `/api/users` route and pass a query parameter `per_page` to specify how many records we want per page.

```php
// routes/api.php

Route::get('/users', 'UserController@index')->name('users.index');
```

### Testing Eloquent Pagination

To verify that the pagination is working correctly, let's write some tests for our API endpoint:

```php
public function test_index()
{
    factory(User::class, 10)->create();

    $response = $this->get('/api/users');

    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'name', 'email'],
        ],
        'meta' => [
            'current_page' => 1,
            'total_pages' => 1,
            'per_page' => 10,
            'from' => 1,
            'to' => 10,
        ],
    ]);
}

public function test_index_with_perpage_parameter()
{
    factory(User::class, 5)->create();

    $response = $this->get('/api/users?per_page=3');

    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'name', 'email'],
        ],
        'meta' => [
            'current_page' => 1,
            'total_pages' => 2,
            'per_page' => 3,
            'from' => 1,
            'to' => 3,
        ],
    ]);
}

public function test_show_user()
{
    $user = User::factory()->create();

    $response = $this->get('/api/users/' . $user->id);

    $response->assertJsonStructure([
        'data' => [
            'name',
            'email',
        ],
    ]);
}
```

By using Eloquent pagination, we have made our API more flexible and easier to manage. We can now fetch a subset of records from the database along with metadata, making it easier for clients to navigate through large datasets.