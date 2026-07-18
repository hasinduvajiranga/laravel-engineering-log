// app/Http/Controllers/TranslationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TranslationController extends Controller
{
    public function index()
    {
        return view('translation.index');
    }

    public function store(Request $request)
    {
        Lang::setLocale($request->input('locale'));
        return redirect()->route('translation.index');
    }
}
```

```php
// app/Http/routes/web.php

Route::get('/translation/{locale}', 'TranslationController@store')->name('translation.store');
Route::view('/translation', 'index')->name('translation.index');