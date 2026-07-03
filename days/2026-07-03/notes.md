# Blade Directives Creation

Blade directives allow you to extend the functionality of your Laravel views by adding custom logic and functionality. In this example, we'll create a new Blade directive that generates a simple HTML element.

## Creating the Directive

First, let's create a new file called `Directive.php` in the `app/Http/Directives` directory:
```php
// app/Http/Directives/Directive.php

namespace App\Http-Directives;

use Illuminate\View\Compilers\Compiler;

class Directive extends Compiler
{
    public function register()
    {
        $this->addDirective('my-directive', function ($view, $directive) {
            // Generate the HTML element here
            return '<div class="test">' . $directive . '</div>';
        });
    }
}
```
In this example, we're defining a new directive called `my-directive` that takes a single argument. The `register()` method is where we define how the directive should be rendered.

## Using the Directive

To use our new directive in your view, simply include it at the top of your Blade file:
```php
// resources/views/test.blade.php

{{ my-directive('Hello, World!') }}
```
This will render an HTML element with the text "Hello, World!" inside a `div` element.

## Customizing the Directive

By default, our directive uses a simple string concatenation to generate the HTML element. However, you can customize this behavior by passing additional arguments or modifying the directive's logic.

For example, let's modify our directive to accept multiple arguments and render an HTML list:
```php
// app/Http/Directives/Directive.php

namespace App\Http-Directives;

use Illuminate\View\Compilers\Compiler;
use Illuminate\Support\Collection;

class Directive extends Compiler
{
    public function register()
    {
        $this->addDirective('my-directive', function ($view, $directive) {
            // Get the arguments from the directive invocation
            $args = array_slice(explode(' ', $directive), 1);

            // Render an HTML list using the arguments
            return '<ul>' . implode('', array_map(function ($arg) {
                return '<li>' . $arg . '</li>';
            }, $args)) . '</ul>';
        });
    }
}
```
Now, if you use our directive like this:
```php
// resources/views/test.blade.php

{{ my-directive('Item 1', 'Item 2', 'Item 3') }}
```
It will render an HTML list with the items "Item 1", "Item 2", and "Item 3".

This is just a basic example of how you can create custom Blade directives in Laravel. The possibilities are endless, and I hope this helps inspire you to create your own!