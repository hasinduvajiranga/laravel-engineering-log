# Blade Layout Stacking

Blade layout stacking allows you to create complex layouts by combining multiple views. In this example, we'll demonstrate how to stack two layouts: `main` and `nav`. The `main` layout will contain the main content of the page, while the `nav` layout will be rendered as a sidebar.

To use layout stacking, you can pass a `$layoutStack` variable to your view from your controller. This variable is an array where each key represents a layout that should be stacked.

Here's an example of how to define the layouts:

```php
// File: resources/views/layouts/main.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    @include('layouts.nav')
    <!-- Main content goes here -->
</body>
</html>
```

```php
// File: resources/views/layouts/nav.blade.php

<nav class="nav">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>
```

When rendering the `pages.index` view, you can pass the layout stack like this:

```php
// File: app/Http/Controllers/LayoutController.php

public function index()
{
    $layoutStack = [
        'main' => View::make('layouts.main')->with('title', 'Main Layout'),
        'nav'  => View::make('layouts.nav')->with('title', 'Navigation Bar')
    ];

    return View::make('pages.index', $layoutStack)->render();
}
```

This will render the `main` layout first, followed by the `nav` layout. The `$title` variable will be passed to both layouts.

You can also use this approach to create more complex layouts by stacking multiple views together. Just remember to update your view files accordingly!