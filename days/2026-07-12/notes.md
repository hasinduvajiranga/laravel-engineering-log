# Blade Loop Variables

In Laravel, a Blade loop variable is a way to access data from a collection in your templates. When you use the `@foreach` directive in Blade, it automatically creates a scope for each iteration of the loop, making it easier to access the current item's properties.

## Using Blade Loop Variables in Your Template

To use a blade loop variable in your template, simply add the `@foreach` directive followed by the collection you want to iterate over. For example:
```php
@foreach($books as $book)
    {{ $book->title }}
@endforeach
```
In this example, `$books` is a collection of book objects and `$book` is the current item being processed in the loop.

## Accessing Properties

To access properties of the current item, you can use dot notation or access them directly. For example:
```php
@foreach($books as $book)
    {{ $book->title }} ({{ $book->author->name }})
@endforeach
```
In this example, `$book->author->name` is accessing the `name` property of the `author` object associated with the current book.

## Loop Variables and Scope

When using a Blade loop variable, Laravel automatically creates a scope for each iteration of the loop. This means that you can access properties of the current item without having to prefix them with the collection name.

For example:
```php
@foreach($books as $book)
    {{ $book->title }} ({{ $author->name }})
@endforeach
```
In this example, `$author` is a variable in scope for each iteration of the loop, even though it was not explicitly passed to the template.