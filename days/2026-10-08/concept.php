// File: app/Imports/CsvImporter.php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Models\Sheet;

class CsvImporter implements ToCollection
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function collection(Collection $collection): array
    {
        foreach ($collection as &$row) {
            // Map the CSV row to the model instance
            $this->mapRowToModel($row, new $this->model());
        }
        return $collection->all();
    }

    private function mapRowToModel(array $row, Model $model): void
    {
        foreach ($row as $key => $value) {
            $model->{$key} = $value;
        }
        // Update the model instance if it already exists in the database
        if ($this->model_exists($model)) {
            $model->save();
        }
    }

    private function model_exists(Model $model): bool
    {
        return $model instanceof $this->model;
    }
}