// File: tests/ImportTest.php

namespace Tests\Import;

use App\Imports\CsvImporter;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Mocks\Concerns\Tests\WithExampleRow;
use Pest\Laravel\FeatureTestCase;
use Pest\Laravel\Http\Request;
use Pest\Laravel\Stub;

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

        $this->withinSession(function () {
            $request = Request::make('POST', '/import/users');

            // Add the CSV file to the request body
            $request->csv($csv);

            // Make the POST request to import the users
            $response = $this->actingAs(User::factory(2)->create())->post($request);
        });

        // Assert that two user records were created in the database
        $this->assertCount(2, DB::table('users')->get());
    }
}