# Eloquent API CORS Configuration

In Laravel, you can configure CORS (Cross-Origin Resource Sharing) to enable cross-origin requests to your API endpoints. Here are the steps:

### Step 1: Install the `cors` package

You need to install the `cors` package using Composer:
```bash
composer require barryvdh/laravel-cors
```

### Step 2: Register the middleware in the kernel

In the `app/Http/Kernel.php` file, register the `CorsMiddleware` in the `$middleware` array:
```php
use Barryvdh\LaravelCors\Cors;

// ...

protected $middleware = [
    // ... other middleware ...
    Cors::class,
];
```

### Step 3: Configure CORS settings

In the `.env` file, add the following configuration for CORS settings:
```makefile
CORS Allowed Origins=*
CORS Allowed Methods=GET,POST,PUT,DELETE,OPTIONS
CORS Allow Credentials=true
```

### Step 4: Use the `Cors` facade in your API endpoints

You can use the `Cors` facade to enable or disable CORS for a specific endpoint:
```php
use Barryvdh\LaravelCors\Cors;

// ...

public function apiEndpoint()
{
    Cors::allow()->origin('https://example.com')->method(['GET', 'POST'])->headers('*');
    return response()->json(['message' => 'Hello World!']);
}
```

### Step 5: Test CORS configuration

Use a tool like Postman or cURL to make a request from a different origin and verify that the API endpoint returns the correct CORS headers.