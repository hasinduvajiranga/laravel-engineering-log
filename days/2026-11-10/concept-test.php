// tests/Http/Livewire/RetriedModelsTest.php

namespace Tests\Integration\Http\Livewire;

use App\Http\Livewire\RetriedModels;
use Livewire\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithDatabase;
use Illuminate\Foundation\Testing\TestSuiteMixin;

class RetriedModelsTest extends TestCase
{
    use TestSuiteMixin, WithFaker, WithDatabase;

    public function testHandleModelRetries()
    {
        Mockery::mock(Http::class)
            ->shouldReceive('withHeaders')
            ->andReturnSelf();

        $retiredModels = new RetriedModels();
        $model = 'test-model';

        // Simulate a successful response
        Http::mock('https://api.example.com/models/' . $model, 200)->get($model);

        $retiredModels->handleModelRetries($model);
        $this->assertEquals(true, $retiredModels->models[$model]);
    }

    public function testHandleModelRetries_Fail()
    {
        Mockery::mock(Http::class)
            ->shouldReceive('withHeaders')
            ->andReturnSelf();

        $retiredModels = new RetriedModels();
        $model = 'test-model';

        // Simulate a failed response
        Http::mock('https://api.example.com/models/' . $model, 404)->get($model);

        $retiredModels->handleModelRetries($model);
        $this->assertEquals(false, $retiredModels->models[$model]);
    }

    public function testHandleModelRetries_Timeout()
    {
        Mockery::mock(Http::class)
            ->shouldReceive('withHeaders')
            ->andReturnSelf();

        $retiredModels = new RetriedModels();
        $model = 'test-model';

        // Simulate a response that times out
        Http::mock('https://api.example.com/models/' . $model, 408)->get($model);

        $retiredModels->handleModelRetries($model);
        $this->assertEquals(false, $retiredModels->models[$model]);
    }
}