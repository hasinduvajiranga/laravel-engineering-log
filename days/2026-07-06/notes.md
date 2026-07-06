### Blade Template Inheritance

Blade template inheritance is a powerful feature in Laravel that allows you to create reusable layouts and templates. This technique is especially useful for maintaining consistency across different views.

#### Overview

Blade template inheritance works by creating a base view that contains the common HTML structure, such as the `head`, `body`, and navigation bars. Then, you can extend this base view using the `@extends` directive to create child views that inherit the layout.

#### Extending a Base View

To extend a base view, you use the `@extends` directive at the top of your Blade template file:
```php
<!-- resources/views/template/index.blade.php -->

@extends('layouts.base')

@section('content')
    <!-- Your content here -->
@endsection
```
In this example, we're extending the `base` layout, which is located in the `resources/views/layouts` directory. The `@section` directive allows us to define a section of content that will be injected into the base view.

#### Inheriting Layout

To inherit the layout from the base view, you can use the `@extends` directive again:
```php
<!-- resources/views/template/layout-change.blade.php -->

@extends('layouts.base')

@section('content')
    <form method="post" action="{{ route('template.layout-change') }}">
        @csrf
        <div class="form-group">
            <label for="layout">Layout:</label>
            <select name="layout" id="layout">
                <option value="">Default</option>
                <option value="custom">Custom</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Change Layout</button>
    </form>
@endsection
```
In this example, we're extending the `base` layout again and defining a new section called `content`.

#### Passing Data

To pass data from the child view to the base view, you can use the `@section` directive with the `$data` variable:
```php
// In resources/views/layouts/base.blade.php

@section('title', 'Default Title')

@section('content')
    <!-- Base content here -->
@endsection
```
Then, in your child view, you can access the data like this:
```php
<!-- In resources/views/template/index.blade.php -->

@extends('layouts.base')

@section('title', 'Custom Title')

@section('content')
    <!-- Your custom content here -->
@endsection
```
In the `TemplateController`, we can use the `$request->input('layout')` to pass data from the child view to the base view:
```php
// In app/Http/Controllers/TemplateController.php

public function layoutChange(Request $request)
{
    $layout = $request->input('layout');

    if ($layout) {
        $view = View::make('template.index', ['layout' => $layout]);
    } else {
        $view = View::make('template.index');
    }

    return $view;
}
```
By using Blade template inheritance, we can create a reusable base layout and child views that inherit the layout while passing custom data. This technique helps to maintain consistency across different views and makes it easier to manage complex layouts.