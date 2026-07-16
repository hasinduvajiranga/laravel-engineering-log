// src/Blade/TemplateExample.php

namespace App\Blade;

use Illuminate\Support\Facades\View;

class TemplateExample
{
    public function getTemplate()
    {
        return View::make('template.example')->render();
    }
}