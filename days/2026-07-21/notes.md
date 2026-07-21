# Custom Eloquent Casts

In Laravel, the `$casts` property of an Eloquent model can be used to define custom casts for certain attributes. A cast is a transformation that is applied when retrieving or setting an attribute.

The `password` cast is automatically included in most applications and should not be overridden unless you have specific requirements that require it to be hashed differently.

However, the `bio` attribute is not included by default because it can contain HTML tags. By adding this custom cast, we can ensure that when retrieving the bio, it will be converted back into plain text using the `html_entity_decode()` function.

The `getBioAttribute()` method allows us to provide a custom implementation for how to retrieve the bio attribute from the database. In this case, we're using `html_entity_decode()` to convert any HTML tags in the stored value back into plain text.

This approach provides flexibility and control over how certain attributes are retrieved or set, making it easier to customize your application's behavior.