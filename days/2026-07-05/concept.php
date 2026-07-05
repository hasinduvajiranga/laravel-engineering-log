// app/View/Creators/BladeCreator.php

namespace App\View\Creators;

use Illuminate\View\View;
use Laravel\Laravel\Facades\View as Façade;

class BladeCreator
{
    public function createView(string $viewName, array $data = [], string $engine = 'blade'): View
    {
        // Validate the view name
        if (!is_string($viewName) || empty($viewName)) {
            throw new \InvalidArgumentException('Invalid view name');
        }

        // Create a new Blade template
        $template = '<!' . ($engine == 'blade' ? ' extends "web.layout" ' : '') . '>' .
                    '<div class="container">' .
                    '<h1>' . ($data['title'] ?? '') . '</h1>' .
                    '<p>' . ($data['description'] ?? '') . '</p>' .
                    '</div>';

        // Render the template
        $view = Façade::make($template, ['name' => $viewName]);

        return $view;
    }
}