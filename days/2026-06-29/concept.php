// src/Components/Heading.php

namespace App\Components;

use Illuminate\View\Component;

class Heading extends Component
{
    use HasAttributes;

    public $title;
    public $level;

    public function __construct($title, $level)
    {
        $this->title = $title;
        $this->level = $level;
    }

    public function render()
    {
        return view('components.heading', [
            'title' => $this->title,
            'level' => $this->level,
        ]);
    }
}
```

```php
// src/Components/Footer.php

namespace App\Components;

use Illuminate\View\Component;

class Footer extends Component
{
    use HasAttributes;

    public $copyright;
    public $links;

    public function __construct($copyright, $links)
    {
        $this->copyright = $copyright;
        $this->links = $links;
    }

    public function render()
    {
        return view('components.footer', [
            'copyright' => $this->copyright,
            'links' => $this->links,
        ]);
    }
}
```

```php
// app/Http/Controllers/ComponentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Heading;
use App\Components/Footer;

class ComponentController extends Controller
{
    public function index()
    {
        $heading = new Heading('Section Title', 'h1');
        $footer = new Footer('Copyright 2023', ['Link 1' => 'https://example.com/link1']);

        return view('components.index', [
            'heading' => $heading,
            'footer' => $footer,
        ]);
    }
}