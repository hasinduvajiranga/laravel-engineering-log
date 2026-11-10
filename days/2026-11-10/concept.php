// app/Http/Livewire/RetriedModels.php

namespace App\Http\Livewire;

use Illuminate\Contracts\Livewire\Livewire;
use Illuminate\Support\Facades\Http;

class RetriedModels extends Livewire
{
    private $models = [];

    public function render()
    {
        return view('livewire.retried-models');
    }

    public function handleModelRetries($model)
    {
        if ($this->models[$model]) {
            return;
        }

        $retries = 0;
        while ($retries <= 3) {
            try {
                // Make API call to retrieve the model
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer YOUR_API_TOKEN',
                    'Content-Type' => 'application/json',
                ])->get('https://api.example.com/models/' . $model);

                if ($response->status() == 200) {
                    // Model was successfully retrieved, add it to the list
                    $this->models[$model] = true;
                    break;
                } elseif ($retries < 3) {
                    // Model not found or failed to retrieve, wait and retry
                    sleep(1000); // Wait for 1 second before retrying
                    $retries++;
                } else {
                    // Max retries reached, log the failure and return an error message
                    logger()->error('Failed to retrieve model ' . $model);
                    break;
                }
            } catch (\Exception $e) {
                logger()->error($e->getMessage());
                sleep(1000); // Wait for 1 second before retrying
                $retries++;
            }
        }

        return view('livewire.retried-models', ['models' => $this->models]);
    }
}