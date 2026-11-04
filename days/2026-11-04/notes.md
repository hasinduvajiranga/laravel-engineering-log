### Eloquent API Compression

Eloquent provides a convenient way to compress your API responses using Gzip. However, it requires some extra configuration and custom implementation.

#### Steps:

1.  Add the following middleware to your `kernel.php` file to enable compression:
    ```php
// File: app/Http/Kernel.php

protected $middleware = [
    // ...
    \Illuminate\Support\FacadesCompression::class,
];
```

2.  Create a custom `compressResponse` method in your controller or service provider to compress the data:
    ```php
// File: app/Http/Controllers/UserController.php

private function compressResponse(array $data): string
{
    $compressedData = gzcompress(serialize($data));

    return $compressedData;
}
```

3.  In your Eloquent query, use the `with` method to eager load related models and compress the response:
    ```php
// File: app/Http/Controllers/UserController.php

public function index()
{
    $users = User::with('address')->get();

    return response()->json($users, 200)->compress();
}
```

4.  Test the compression feature using Pest or PHPUnit:
    ```php
// File: tests/Feature/UserControllerTest.php

test_index_compressed()
{
    factory(User::class, 5)->create();

    $response = $this->actingAs(Request::create('/users', 'GET'))
        ->json($this->get('api/users'));

    // Assert the response contains compressed data.
    $compressedData = substr($response->body, strpos($response->body, "\x1f\x8b") + 2);
    $uncompressedData = unserialize(gzuncompress($compressedData));

    // Assert the compression did not affect the actual data.
    $this->assertEquals($uncompressedData, User::all()->toArray());
}
```

#### Benefits:

*   Reduced network latency and improved performance by compressing response bodies
*   Increased bandwidth efficiency for large datasets
*   Simplified caching mechanisms using compressed responses