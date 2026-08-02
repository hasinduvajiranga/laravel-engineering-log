# Eloquent Hidden Attributes

Eloquent, Laravel's ORM, provides a `hidden` property on models that allows you to specify attributes that should not be included in the model's JSON representation or when serializing the model.

When an attribute is marked as hidden, it will not appear in the model's `toArray()` method or when serializing the model using the `json_encode()` function. This can be useful for hiding sensitive information such as passwords from being exposed in the model.

In addition to specifying individual attributes, you can also use a regular expression to match multiple attribute names. For example:
```php
protected $hidden = ['password', 'remember_token', \Illuminate\Support\Str::of('.key')->regex()];
```
This would hide any attribute whose name matches the `.key` pattern.

You can also use this feature to validate data before it is saved to the database. By adding additional logic in the `__construct()` method, you can perform validation or other actions on the attributes before they are set.

```php
public function __construct(array $attributes = [])
{
    parent::__construct($attributes);

    // Add validation logic here
}
```
In summary, Eloquent hidden attributes provide a convenient way to hide sensitive information from being exposed in the model's representation and can be used for validation or other purposes.