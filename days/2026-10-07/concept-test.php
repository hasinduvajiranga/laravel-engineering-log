// app/Exports/EloquentExportedData.php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EloquentExportedData implements FromView
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function view()
    {
        return view('exports.{{ $this->model->getTable() }}', [
            'data' => $this->model->get(),
        ]);
    }
}