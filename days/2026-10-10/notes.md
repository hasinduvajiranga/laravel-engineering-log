# Eloquent JSON Export

Eloquent provides a convenient way to export data from models in JSON format. This can be useful for API responses, logging, or other scenarios where you need to output data as a JSON array.

To use the `toJson` method on an Eloquent model, simply call it like this:
```php
$category = Category::find(1);
$json = $category->toJson();
```
This will return a JSON representation of the category object in a simple format. You can customize the output by passing additional parameters to the `toJson` method.

For example, you can use the `format` parameter to specify the output format:
```php
$category = Category::find(1);
$json = $category->toJson('json');
```
This will return JSON data in a more structured format.

Eloquent also provides an `Xml` function for exporting XML data:
```php
$category = Category::find(1);
$xml = $category->Xml();
```
However, this is not as straightforward to use as the `toJson` method and requires more manual work.

It's worth noting that Eloquent's JSON export functionality can be used in conjunction with other Laravel features, such as API routes and middleware. By using the `toJson` or `Xml` methods, you can create robust and efficient data export mechanisms for your application.

In this example, we've created a `CategoryController` that handles GET requests to the `/category` endpoint. The controller uses Eloquent's `toJson` method to export the category data in JSON format. We've also added some tests to ensure that the exported data is correct and that the response is in the expected format.

By using Eloquent's JSON export functionality, you can create efficient and scalable data export mechanisms for your Laravel application.