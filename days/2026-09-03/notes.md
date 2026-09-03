### Eloquent JSON Column Mutators

Eloquent JSON column mutators provide a way to manipulate the data stored in a JSON column. These mutators allow you to easily convert JSON data from strings to objects or vice versa.

**Creating a Custom Mutator**

To create a custom mutator, extend the `Mutator` class and implement the `apply` method. This method should return the transformed value.

```php
class JsonMutator extends Mutator
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function apply($value)
    {
        return JSON::toAscii($value);
    }
}
```

**Using a Custom Mutator with Eloquent**

To use a custom mutator, add it to your model using the `use` keyword.

```php
class User extends Model
{
    use JsonMutator('json_data');

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function getJsonDataAttribute()
    {
        return json_decode($this->attributes['json_data'], true);
    }
}
```

**Testing Custom Mutators**

To test custom mutators, use a testing framework like PHPUnit. Create a test class that extends the `TestCase` class and use the `assertEqual` method to verify the transformation.

```php
class JsonMutatorTest extends TestCase
{
    // ...

    public function testApply()
    {
        $mutator = new JsonMutator('json_data');
        $value = '{"key": "value"}';

        self::assertEquals(json_encode($value), $mutator->apply($value));

        $value = 'Invalid JSON';
        self::assertEquals('', $mutator->apply($value));
    }
}
```

Note: The `JsonMutator` class uses the `JSON` facade to convert JSON data from strings to objects. This is a convenient way to handle JSON transformations in Eloquent, but it may not be suitable for all use cases.