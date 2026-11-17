# Eloquent API Error Tracking

Eloquent, Laravel's ORM (Object Relational Mapping) system, provides a robust way to track errors in an API. This guide outlines the process of implementing error tracking using Eloquent models.

## Creating the Error Model

First, create a new model `Error` that extends `Illuminate\Database\Eloquent\Model`. Add the necessary fields: `message`, `code`, and `stack_trace`.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Error extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'code', 'stack_trace'];

    public function errors()
    {
        return $this->hasMany(ErrorDetail::class, 'error_id');
    }
}
```

## Creating the Error Detail Model

Create another model `ErrorDetail` that extends `Illuminate\Database\Eloquent\Model`. Add the necessary fields: `error_id` and `detail`.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ErrorDetail extends Model
{
    use HasFactory;

    protected $fillable = ['error_id', 'detail'];

    public function error()
    {
        return $this->belongsTo(Error::class, 'error_id');
    }
}
```

## Creating a Test for the Error Model

Create a test `ErrorTest` to verify that the error model can be created and saved.

```php
public function testCreateError()
{
    $error = new Error();
    $error->message = 'Example error message';
    $error->code = 500;
    $error->stack_trace = '...';

    $error->save();

    $this->assertEquals(1, Error::count());
}
```

## Creating Tests for the Errors Relationship

Create tests to verify that the `errors` relationship is working correctly.

```php
public function testErrors()
{
    $error = new Error();
    $error->message = 'Example error message';
    $error->code = 500;
    $error->stack_trace = '...';

    $error->errors()->create(['detail' => 'Error detail']);

    $this->assertCount(1, $error->errors);
}

public function testErrorDetail()
{
    $error = new Error();
    $error->message = 'Example error message';
    $error->code = 500;
    $error->stack_trace = '...';

    $error->errors()->create(['detail' => 'Error detail']);

    $errorDetail = $error->errors()->first();

    $this->assertEquals('Error detail', $errorDetail->detail);
}
```

This implementation provides a robust way to track errors in an API using Eloquent models. The `Error` model serves as the parent model, and the `ErrorDetail` model serves as the child model for each error. The `errors` relationship allows you to easily retrieve the details of each error.