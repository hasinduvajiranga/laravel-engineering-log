// File: app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    // Using route name prefix for 'dashboard' route
    public function getDashboard()
    {
        return view('dashboard');
    }
}
```

```php
// File: routes/web.php

Route::name_prefix('admin-');
Route::get('/home', 'HomeController@index');
Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'HomeController@dashboard']);