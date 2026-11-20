# Eloquent API Rollbar Configuration

In Laravel, the built-in exception handling mechanism can be enhanced by integrating with Rollbar, a popular error tracking and monitoring service. Here's how you can configure Eloquent API Rollbar:

## Step 1: Install the required packages
Firstly, install the `rollbar` package using Composer:
```bash
composer require rollbar/rollbar
```

## Step 2: Set up Rollbar configuration

Create a new file called `.env.local` in your Laravel project and add the following lines:
```makefile
ROLLBAR_TOKEN=your_rollbar_token_here
ROLLBAR_ENVIRONMENT=production
```
Replace `your_rollbar_token_here` with your actual Rollbar token.

## Step 3: Configure the exception handler

In your Laravel project, open the file `app/Exceptions/Handler.php`. This is where you'll configure the exception handling mechanism to integrate with Rollbar. Add the following code:
```php
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->registerExceptionHandlers();
    }

    protected function resolveException(Throwable $exception): string | null
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return Rollbar::capture($exception->getMessage(), 'Eloquent API Model Not Found');
        } elseif ($exception instanceof \Illuminate\Database\QueryException && $exception->getCode() === 50001) {
            return Rollbar::capture($exception->getMessage(), 'Eloquent API Query Exception');
        }

        return parent::resolveException($exception);
    }
}
```
In this code, we're defining a new exception handler that checks for Eloquent model not found and query exceptions. If an exception is caught, it will be sent to Rollbar with the desired error message.

## Step 4: Update your Laravel version (if necessary)

As of Laravel 9.x, the built-in exception handling mechanism has changed. You may need to update your `ExceptionHandler` class to use the new syntax:
```php
protected function resolveException(Throwable $exception): string | null
{
    if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        return Rollbar::capture($exception->getMessage(), 'Eloquent API Model Not Found');
    } elseif ($exception instanceof \Illuminate\Database\QueryException && $exception->getCode() === 50001) {
        return Rollbar::capture($exception->getMessage(), 'Eloquent API Query Exception');
    }

    return parent::resolveException($exception);
}
```
## Step 5: Run the migration (if necessary)

If you're using a newer version of Laravel, you may need to run an additional migration to create the `exceptions` table:
```bash
php artisan migrate --seed=database/migrations/2023_02_20_000000_create_exceptions_table
```
This will create the necessary table for storing exceptions.

## Step 6: Restart your server

After updating the exception handler and running any necessary migrations, restart your Laravel development server or application to ensure that the changes take effect.

That's it! With these steps, you've successfully integrated Rollbar with your Eloquent API in Laravel.