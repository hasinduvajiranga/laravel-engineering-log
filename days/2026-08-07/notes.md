# Eloquent Fulltext Search

Eloquent's full-text search functionality allows you to query models that have translatable attributes. This is achieved by using a separate model for the translation table and defining a relationship between it and your main model.

## Step 1: Define a searchable model with translatable attributes

Create a new migration for the translation table:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSearchableModelsTable extends Migration
{
    public function up()
    {
        Schema::create('searchable_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();

            // Add any other columns you want to include in the search query
        });
    }

    public function down()
    {
        Schema::dropIfExists('searchable_models');
    }
}
```

Create a new model for the translation table:

```php
// File: app/Models/SearchableModelTranslation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SearchableModelTranslation extends Model
{
    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function model(): HasMany
    {
        return $this->belongsTo(SearchableModel::class);
    }
}
```

Update your main model to include the translatable attributes:

```php
// File: app/Models/SearchableModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Blade;

class SearchableModel extends Model
{
    public $translatedAttributes = ['name'];

    // Add any other relationships you want to include in the search query
}
```

## Step 2: Define a relationship between the main model and the translation table

In your main model, define a relationship with the translation table:

```php
// File: app/Models/SearchableModel.php (continued)

public function translations(): HasMany
{
    return $this->hasMany(SearchableModelTranslation::class);
}

public function getTranslatedAttribute($value)
{
    return $this->translations()->where('name', 'like', '%' . $value . '%')->first()->model();
}
```

## Step 3: Perform a full-text search query

In your controller, perform the full-text search query using Eloquent:

```php
// File: app/Http/Controllers/SearchController.php (continued)

public function index(Request $request)
{
    // Get the model instance
    $model = new SearchableModel();

    // Get the search query
    $query = $request->input('q');

    if ($query) {
        // Perform the full-text search query
        $searchResults = $model
            ->whereHas('translatable', function ($query) use ($query) {
                $query->select('id', 'name')
                      ->from($model->getTable())
                      ->where('name', 'like', '%' . $query . '%');
            });

        return view('search.index', compact('searchResults'));
    }

    // Return a 404 error if no search query is provided
    return response()->view('errors.404', [], 404);
}
```

This example demonstrates how to perform a full-text search using Eloquent's `whereHas` method. It also shows how to use Blade templating to display the search results on a page.