# Laravel API Resources

Laravel provides a simple and elegant way to create API resources that conf
conform to the JSON API specification. In this example, we'll explore how t
to define custom resources for our `User` and `Product` models.

## What are API Resources?

API resources are classes that implement the `JsonResource` interface, whic
which allows us to transform our Eloquent models into JSON responses. By de
default, Laravel provides a few built-in resource classes, but we can creat
create our own to tailor our responses to our needs.

## Defining Custom Resources

To define a custom resource, we create a new class that extends the `JsonRe
`JsonResource` interface. For example:
```php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializab
array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // Add other fields as needed
        ];
    }
}
```
## Using Custom Resources

Once we've defined our custom resources, we can use them in our API control
controllers to generate responses. For example:
```php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return new UserResource($users);
    }
}
```
By using custom resources, we can simplify our API responses and make them 
more consistent with the JSON API specification.