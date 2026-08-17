# Eloquent Debugging with Ray

Eloquent is a powerful ORM (Object-Relational Mapping) system in Laravel that simplifies the interaction between your application and database. However, it can sometimes be challenging to debug issues related to Eloquent.

That's where Ray comes in - a lightweight performance profiling tool for PHP applications. With Ray, you can easily identify performance bottlenecks in your code and understand how Eloquent is interacting with your database.

## Eager Loading vs Lazy Loading

In Eloquent, you have two options for loading related models: eager loading and lazy loading.

### Eager Loading

Eager loading involves loading all related models at once. This can be beneficial when working with large datasets or complex relationships.

```php
$posts = $user->posts()->with('user')->get();
```

Ray will show you how long it took to fetch these 10 posts, along with any other details about the query execution.

### Lazy Loading

Lazy loading involves loading related models on demand. This can be beneficial when working with small datasets or simple relationships.

```php
$posts = $user->posts()->latest()->paginate(10);
```

Ray will show you how long it took to fetch these 10 posts, along with any other details about the query execution.

## Using Ray for Eloquent Debugging

By using Ray in conjunction with Eloquent, you can gain valuable insights into your application's performance and optimize your queries accordingly.

To get started, simply add the `Ray` facade to your application and use it in your Eloquent tests as shown above. This will give you a deeper understanding of how Eloquent is interacting with your database and allow you to make informed decisions about your application's performance.