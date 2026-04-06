// File: app/Console/Commands/CreateUser.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');

        if (!userExists($email)) {
            User::create([
                'name' => $name,
                'email' => $email,
            ]);

            $this->info("User created successfully");
        } else {
            $this->error("Email already exists");
        }
    }

    private function userExists($email)
    {
        return User::where('email', $email)->exists();
    }
}