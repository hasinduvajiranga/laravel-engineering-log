# Eloquent Custom Paginator
In Laravel, the `LengthAwarePaginator` class provides a flexible way to paginate data. However, sometimes you might need custom pagination with additional parameters such as page size or per-page limit.

## Step 1: Create a custom paginator

To create a custom paginator, we'll use the `LengthAwarePaginator` class and extend its functionality by adding our own logic for retrieving the total count of records. We can achieve this by calling the `count()` method on the Eloquent model.

```php
// app/Http/Controllers/PaginatorController.php

public function index(Request $request)
{
    $models = Model::all();

    $paginator = new LengthAwarePaginator($models, $request->input('per_page', 10), 15);
    $paginator->appends(['page' => $request->input('page', 1)]);

    // Custom pagination logic
    $totalCount = Model::count();
    $paginator->setTotalCount($totalCount);

    return response()->view('paginator.index', compact('paginator'));
}
```

## Step 2: Test the custom paginator

To test our custom paginator, we'll create a test class that verifies the paginated data and pagination links.

```php
// tests/Http/PaginatorControllerTest.php

public function test_index()
{
    $response = $this->get('/paginator');

    // Verify paginated data
    $data = $response->json();
    $this->assertEquals(20, $data['total']);
    $this->assertEquals(10, $data['per_page']);

    // Test pagination links
    $links = ['prev', 'next'];
    foreach ($links as $link) {
        $response = $this->get('/paginator?page=' . $link);
        $response->assertViewIs('paginator.index');
        $response->assertJson(['total' => 20, 'per_page' => 10]);
    }
}
```

## Step 3: Add custom pagination logic to the model

If you need more complex pagination logic, you can add a method to your Eloquent model that returns the total count of records.

```php
// app/Models/Model.php

public function getTotalCount()
{
    return self::count();
}
```

Then, in the `PaginatorController`, we'll call this method and update the paginator with the new total count.

```php
// app/Http/Controllers/PaginatorController.php

public function index(Request $request)
{
    $models = Model::all();

    $paginator = new LengthAwarePaginator($models, $request->input('per_page', 10), 15);
    $paginator->appends(['page' => $request->input('page', 1)]);

    // Custom pagination logic
    $totalCount = Model::getTotalCount();
    $paginator->setTotalCount($totalCount);

    return response()->view('paginator.index', compact('paginator'));
}
```

By following these steps, you can create a custom paginator in Laravel that provides more flexibility and control over the pagination process.