# Eloquent Data Export Techniques

In Laravel, when dealing with large datasets and the need to export data in a specific format (e.g., CSV, Excel), it's essential to use the right techniques. Here are some key concepts and examples for exporting data using Eloquent:

### 1. Using the `FromCollection` trait

The `EloquentExport` class extends the `FromCollection` trait from the Maatwebsite/Excel package. This allows you to easily export a collection of models.

```php
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
```

### 2. Using the `FromView` trait

For more complex data formats, such as Excel, you can use the `FromView` trait to create a view that exports the data.

```php
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
```

### 3. Creating an Excel writer

To write the exported data to an Excel file, you can use the `Writer` class from Maatwebsite/Excel.

```php
$writer = new Writer(new MimeType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'));
$excelWriter = $writer->open($exporter);
```

### 4. Testing export functionality

When testing export functionality, make sure to use a package like Pest or PHPUnit to verify that the file exists and has the correct data.

```php
public function testEloquentExport()
{
    // Create some test data
    $users = factory(User::class, 10)->create();

    // Export the data
    $exporter = new EloquentExport(User::class);
    $writer = new Writer(new MimeType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'));
    $excelWriter = $writer->open($exporter);

    foreach ($users as $user) {
        $excelWriter->cell(1, 1, $user->name);
        // Add more columns as needed
    }

    // Close the writer and verify that the file exists
    $excelWriter->close();

    Pest::assertFileExists('exports/users.xlsx');
}
```