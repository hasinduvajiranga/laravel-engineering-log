// tests/Unit/EloquentRestoringServiceProviderTest.php

namespace Tests\Unit;

use App\Providers\EloquentRestoringServiceProvider;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EloquentRestoringServiceProviderTest extends TestCase
{
    public function testRestorationHooks()
    {
        // Test the restoration hooks for the `beforeRestore` type.
        $this->setUpRestorationLog();
        $restorationHook = new \stdClass();
        $restorationHook->action = 'beforeRestore';
        $restorationHook->data = ['model_name' => 'TestModel'];

        // Assert that a call was made to each restoration hook callback for the `beforeRestore` type.
        foreach ($this->restorationHooks['beforeRestore'] as $callback) {
            $result = $callback($restorationHook);
            $this->assertTrue($result, "Restoration hook callback failed.");
        }
    }

    public function testRestorationCompleted()
    {
        // Test the restoration hooks for the `afterRestore` type.
        $this->setUpRestorationLog();
        $restorationHook = new \stdClass();
        $restorationHook->action = 'afterRestore';
        $restorationHook->data = ['model_name' => 'TestModel'];

        // Assert that a call was made to each restoration hook callback for the `afterRestore` type.
        foreach ($this->restorationHooks['afterRestore'] as $callback) {
            $result = $callback($restorationHook);
            $this->assertTrue($result, "Restoration hook callback failed.");
        }
    }

    private function setUpRestorationLog()
    {
        // Set up the restoration log.
        DB::table('restoration_log')->insert([
            'model_name' => 'TestModel',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}