// File: app/Http/Controllers/AnonymousComponentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AnonymousComponentController extends Controller
{
    public function index()
    {
        $component = View::make('anonymous.component', [
            'name' => 'John Doe',
            'age' => 30,
        ]);

        return $component;
    }
}
```

```php
// File: app/Views/Anonymous/Component.blade.php

<x-greet :name="{{ $name }}" />
<p>Your age is {{ $age }}.</p>
```

```php
// File: app/Http/Controllers/BladeComponentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BladeComponentController extends Controller
{
    public function index()
    {
        $component = View::make('blade.component', [
            'name' => 'Jane Doe',
        ]);

        return $component;
    }
}
```

```php
// File: app/Views/Blade/Component.blade.php

<x-greet :name="{{ $name }}" />
<p>Your name is {{ $name }}.</p>