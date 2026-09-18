namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\ProgressBar;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $bar = ProgressBar::create('Seeding users table');

        $users = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com'],
            // Add more users here
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);

            $bar->advance(1);
        }

        $bar->finish();
    }
}