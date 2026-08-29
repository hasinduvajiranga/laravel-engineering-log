# Eloquent Guarded Attributes

In Laravel, Eloquent models provide a convenient way to interact with your database tables. However, sometimes you need to prevent certain attributes from being settable directly using the model's methods.

## What are guarded attributes?

Guarded attributes are those that cannot be set or updated through the model's methods. Instead, they can only be retrieved and read-only. This is useful when working with sensitive information such as passwords or API keys.

## How to define guarded attributes

To define guarded attributes, you use the `$guarded` property on your Eloquent model. This array specifies which attributes should not be settable.

```php
protected $guarded = [
    'password',
    // Add more attributes as needed
];
```

## Setting password attribute

When working with passwords, it's a good practice to hash and salt them instead of storing plain text. To achieve this in Eloquent, you can override the `setPasswordAttribute` method.

```php
public function setPasswordAttribute($value)
{
    if ($this->isDirty('password')) {
        $this->attributes['password'] = Hash::make($value);
    }
}
```

In this example, when setting the password attribute, Eloquent will hash and salt it using the `Hash` facade.

## Best practices

*   Always define guarded attributes on your Eloquent models to prevent sensitive information from being exposed.
*   Override the `setPasswordAttribute` method to handle password hashing and salting securely.
*   Use the `$guarded` property to specify which attributes should not be settable.