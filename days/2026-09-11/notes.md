# Eloquent Pagination Strategies

Eloquent provides several pagination strategies that can be used to manage the number of records returned in a paginated response.

### 1. Manual Pagination

One common approach is to use a manual pagination system where you pass the `per_page` parameter as a query string parameter. In this case, we'll create a controller that handles pagination and returns the results with the correct pagination metadata.

```php
public function index(Request $request)
{
    $books = Book::paginate($request->input('per_page', 10));

    return view('pagination.index', compact('books'));
}
```

### 2. Using `Illuminate\Pagination\LengthAwarePaginator`

Eloquent also provides a built-in pagination system using the `LengthAwarePaginator` class. This approach is more flexible and allows for more advanced pagination logic.

```php
$books = Book::paginate($request->input('per_page', 10));
```

### 3. Using a Third-Party Library

There are also third-party libraries available that provide more advanced pagination features, such as filtering, sorting, and total counts.

```php
use App\Models\Book;
use Spatie\Paginator\Paginator;

$paginator = new Paginator(Book::all(), $request->input('per_page', 10));
```

### Best Practices

When choosing a pagination strategy, consider the following best practices:

* Use a consistent approach across your application.
* Consider using query parameters to manage pagination.
* Use caching to improve performance.
* Provide total count metadata in the response.