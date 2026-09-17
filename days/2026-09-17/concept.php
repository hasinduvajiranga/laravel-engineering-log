// app/Database/Seeders/CreateUsersTableSeeder.php

namespace App\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersTableSeeder extends Seeder
{
    public function run()
    {
        // Insert data into the users table
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}