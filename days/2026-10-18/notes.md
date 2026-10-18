# Eloquent OpenAPI Integration

This guide provides a deep-dive technical example of integrating Laravel's Eloquent ORM with the [LaravelOpenApi](https://github.com/LaravelOpenApi) package to generate an OpenAPI document for your API.

## Installing the Package

To use this feature, you'll need to install the `laravel-openapi` package using Composer:

```bash
composer require laravel/open-api
```

## Configuration

You'll need to add the following lines to your `config/services.php` file in order to use the OpenAPI documentation:

```php
'openApi' => [
    'title' => 'My API',
    'description' => 'This is my API',
    'version' => '1.0',
],
```

## Usage

To generate an OpenAPI document for your Eloquent model, you can use the `OpenApi` facade:

```php
use LaravelOpenApi\OpenApi;

$openApi = new OpenApi();
$openApiDoc = $openApi->generate(Product::class);
```

You can also specify a custom format for your OpenAPI document by passing an array of options to the `generate()` method:

```php
$openApi = new OpenApi();
$openApiDoc = $openApi->generate(Product::class, ['format' => 'yaml']);
```

## API Documentation

The generated OpenAPI document can be used to generate documentation for your API using tools like Swagger UI or OpenAPI Editor.

To use the `ProductController` class above in a real application, you'll need to register it with the `routes/api.php` file:

```php
Route::apiResource('products', ProductController::class);
```

This will create an API endpoint at `/products` that returns a JSON response containing all products, or a single product by ID.

You can then use the OpenAPI documentation generated above to generate HTML documentation for your API using tools like Swagger UI or OpenAPI Editor.