# Form Request Authorization

Form request authorization is a feature in Laravel that allows you to validate and authorize incoming requests before they reach the controller. This can help prevent unauthorized access, data tampering, or other malicious activities.

## Implementing Form Request Authorization

To implement form request authorization, create a new class in the `app/Http/Requests` namespace, extending `Illuminate\Foundation\Http\FormRequest`. In this class, you should override the `authorize` method to determine if the user is authorized to make the request. The `rules` method should be used to define validation rules for the incoming data.

## Using Form Request Authorization

To use form request authorization, create a new instance of your form request class and pass it to the `Request` object in your controller. For example:
```php
public function index(VendorRequest $request)
{
    // Request is authorized if it returns true from the authorize method.
}
```

## Advanced Authorization

Form request authorization can be extended to include more advanced authorization logic using the `can` method, which allows you to check if a user has a specific permission or role. For example:
```php
public function authorize()
{
    $id = $this->input('id');
    return Auth::user()->can('view_vendor', $id);
}
```
This will only allow users with the `view_vendor` permission to access the request.

## Testing Form Request Authorization

Form request authorization can be tested using Pest or PHPUnit tests. For example:
```php
testAuthorized()
{
    $this->actingAs(User::factory()->create());
    $response = $this->post('/vendors', [
        'id' => 1,
        '_method' => 'get',
    ]);
    $response->assertStatus(200);
}

testUnauthorized()
{
    $this->post('/vendors', [
        'id' => 1,
        '_method' => 'get',
    ])->assertStatus(403);
}
```
This will test that authorized users can access the request, and unauthorized users receive a 403 response.