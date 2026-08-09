// app/Factory/Eloquent.php
namespace App\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Support\Providers\Facades\Schema;

class EloquentFactory extends Factory
{
    protected $model = 'App\Model\Entity';

    public function definition()
    {
        return [
            'id' => $this->faker->numberBetween(1, 100),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            // Add more fields as needed
        ];
    }

    public function hasFactory()
    {
        return Schema::hasTable($this->model);
    }
}