// App/Http/Controllers/BladeIncludeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BladeIncludeController extends Controller
{
    public function includeView()
    {
        return view('include-view', ['message' => 'Hello from include view!']);
    }
}

// App/Http/Controllers/BladeComponentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Components\BladeComponent;

class BladeComponentController extends Controller
{
    public function render()
    {
        return view('component-view', ['message' => 'Hello from component view!']);
    }
}