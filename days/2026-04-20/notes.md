# Eloquent Accessors and Mutators
### Overview

Eloquent accessors and mutators are a powerful feature in Laravel's Eloquen
Eloquent ORM. They allow you to manipulate data in your models without expo
exposing the underlying database columns.

An accessor is a method that returns the value of an attribute, while a mut
mutator is a method that sets the value of an attribute. By using accessors
accessors and mutators, you can transform data as it is retrieved or update
updated from the database.

### Accessors

Accessors are methods on your model that return the value of an attribute. 
You define an accessor by adding a `get` method with a name that matches on
one of the attributes in your model. The method should return the desired v
value for that attribute.

Here's an example of an accessor for a `User` model:
```php
public function getFullNameAttribute($value)
{
    return ucwords($this->attributes['name']);
}
```
In this example, the `getFullNameAttribute` method returns the full name of
of the user as uppercase. When you access the `full_name` attribute on your
your `User` instance, it will call this accessor and return the uppercase v
value.

### Mutators

Mutators are methods on your model that set the value of an attribute. You 
define a mutator by adding a `set` method with a name that matches one of t
the attributes in your model. The method should accept the new value for th
that attribute as an argument.

Here's an example of a mutator for a `User` model:
```php
public function setEmailAttribute($value)
{
    $this->attributes['email'] = strtolower($value);
}
```
In this example, the `setEmailAttribute` method sets the email address of t
the user to lowercase when it is set. When you call `setEmail('JOHN DOE@exa
DOE@example.com')`, the value will be converted to lowercase before being s
stored in the database.

### Benefits

Using accessors and mutators provides several benefits:

* **Data transformation**: You can transform data as it is retrieved or upd
updated from the database, making your code more readable and maintainable.
maintainable.
* **Data protection**: By exposing only the values that are ne
necessary for your application, you reduce the risk of sensitive informatio
information being exposed.
* **Consistency**: Accessors and mutators ensure consistency in your data b
by enforcing a single source of truth.

### Best Practices

Here are some best practices to keep in mind when using accessors and mutat
mutators:

* Use meaningful names for your accessors and mutators that clearly indicat
indicate what the method does.
* Keep your accessors and mutators concise and focused on one task each.
* Avoid exposing sensitive information through your accessors or mutators.
* Use these methods judiciously, as they can add complexity to your codebas
codebase.