// app/Exports/EloquentExport.php

namespace App\Exports;

use Illuminate\Contracts。\Exportable;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;

class EloquentExport implements FromCollection, Exportable
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function collection()
    {
        return $this->model->get();
    }
}