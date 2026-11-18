### Eloquent API Sentry Integration

This integration allows your Laravel application to authenticate users using Eloquent and store their session information with Sentry. It provides two endpoints: `authenticate` and `authorize`.

#### Authenticate Endpoint

The `authenticate` endpoint takes user credentials as input, authenticates the user using Eloquent, and returns an access token if successful.

```php
// Route definition:
Route::post('/sentry/authenticate', 'SentryController@authenticate');
```

#### Authorize Endpoint

The `authorize` endpoint retrieves a protected resource by ID, checks if the authenticated user has permission to access the resource, and returns a success or error message accordingly.

```php
// Route definition:
Route::post('/sentry/authorize/{id}', 'SentryController@authorize');
```

#### Technical Requirements

* Laravel 8.x or higher
* Eloquent 9.x or higher
* Sentry 8.x or higher
* PHP 8.x or higher