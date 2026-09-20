// src/Factory/EloquentStatefulFactory.php

namespace App\Factories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\Factory as TestableFactory;

class EloquentStatefulFactory extends TestableFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\User::class;

    /**
     * Define the stateful configuration for the factory.
     *
     * @param array|static $properties
     *
     * @return void
     */
    public function definition(array|static $attributes, \Illuminate\Database\Eloquent\Builder $query)
    {
        // Set up a relationship with another model (in this case, a Post)
        if ($attributes['post_id'] && Schema::hasColumn($this->model->getTable(), 'posts')) {
            $query->with('post');
        }

        // Create an instance of the model
        return parent::definition($attributes, $query);
    }
}