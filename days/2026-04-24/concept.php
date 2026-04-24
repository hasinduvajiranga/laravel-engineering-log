// File: app/Services/Pipeline.php

namespace App\Services;

use Closure;
use Illuminate\Pipeline\PipelineInterface;

class Pipeline implements PipelineInterface
{
    private $steps = [];

    public function addStep(Closure $step)
    {
        $this->steps[] = $step;
    }

    public function run($request)
    {
        foreach ($this->steps as $step) {
            $response = $step($request);
            if (!$response) {
                return false;
            }
        }
        return true;
    }
}

// File: app/Services/Pipeline/Step1.php

namespace App\Services\Pipeline;

use Illuminate\Http\Request;
use Closure;

class Step1
{
    public function handle(Request $request)
    {
        // Add step 1 logic here, e.g., logging the request
        return true; // pass to the next step
    }
}

// File: app/Services/Pipeline/Step2.php

namespace App\Services\Pipeline;

use Illuminate\Http\Request;
use Closure;

class Step2
{
    public function handle(Request $request)
    {
        // Add step 2 logic here, e.g., validating user input
        return true; // pass to the next step
    }
}

// File: app/Services/Pipeline/Step3.php

namespace App\Services\Pipeline;

use Illuminate\Http\Request;
use Closure;

class Step3
{
    public function handle(Request $request)
    {
        // Add step 3 logic here, e.g., creating a new resource
        return true; // pass to the next step
    }
}