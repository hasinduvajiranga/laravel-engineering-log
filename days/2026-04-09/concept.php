// File: app/Console/Commands/HorizonConfigCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class HorizonConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizon:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure Laravel Horizon';

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
        $this->comment('Configuring Laravel Horizon...');

        Config::set('horizon', [
            'queue' => [
                // Your queue configuration here
                'default' => ['job-class' => App\Jobs\MyJob::class],
            ],
        ]);

        $this->info('Horizon configuration updated successfully.');
    }
}