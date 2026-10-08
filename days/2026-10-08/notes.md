# Eloquent CSV Import Handling

Eloquent provides a robust way to import data from CSV files. However, it doesn't offer built-in support for handling large imports efficiently.

## Approach Overview

To handle Eloquent CSV imports effectively, you can create a custom importer that uses the `Maatwebsite\Excel` package's features.

### Step 1: Create a Custom Importer Class

Create a new class that implements the `ToCollection` interface from `Maatwebsite\Excel`. This class will contain the logic for mapping each CSV row to an Eloquent model instance.

```php
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;

class CsvImporter implements ToCollection
{
    // ...
}
```

### Step 2: Map Each Row to a Model Instance

In the `collection` method, iterate through each row in the CSV collection. For each row, create a new instance of the model using its constructor.

```php
public function collection(Collection $collection): array
{
    foreach ($collection as &$row) {
        // Create a new instance of the User model
        $this->mapRowToModel($row, new User());
    }
    return $collection->all();
}

private function mapRowToModel(array $row, Model $model): void
{
    // ...
}
```

### Step 3: Update Existing Models

If a model instance already exists in the database, update its attributes with the values from the CSV row. Use the `model_exists` method to check if an existing model instance is found.

```php
private function mapRowToModel(array $row, Model $model): void
{
    foreach ($row as $key => $value) {
        // Update the model's attribute
        $model->{$key} = $value;
    }

    // Check if an existing model instance is found
    if ($this->model_exists($model)) {
        $model->save();
    }
}
```

### Step 4: Test Your Importer

Create a test class to verify that the importer correctly imports data from a CSV file. Use Pest's feature testing functionality to make HTTP requests and assert that the expected data is created in the database.

```php
use Tests\Import;

class ImportTest extends FeatureTestCase
{
    public function test_import_csv_users()
    {
        // Create a CSV file with sample data
        $csv = 'User,Email,Name,Age'
            . PHP_EOL
            . 'John,john@example.com,John Doe,25'
            . PHP_EOL
            . 'Jane,jane@example.com,Jane Doe,30';

        // Make the POST request to import users from the CSV file
        $response = $this->actingAs(User::factory(2)->create())->post('/import/users', ['csv' => $csv]);

        // Assert that two user records were created in the database
        $this->assertCount(2, DB::table('users')->get());
    }
}
```

By following these steps and using a custom importer class, you can efficiently handle large CSV imports for your Eloquent models.