# Eloquent API Versioning

Eloquent API versioning allows you to manage multiple versions of a resource in a single database table. This feature is particularly useful when handling different stages of a product development lifecycle, such as beta and production versions.

## How it works

When using Eloquent API versioning, each time the `versionNumber` attribute is updated, Laravel creates a new entry in the corresponding model's `userVersions` table. The `userVersions` method returns a collection of all user versions for a specific user.

## Benefits

*   **Centralized data management**: All user version history is stored in a single database table.
*   **Easier data analysis and reporting**: With all version history stored in one place, you can more easily track changes and performance over time.
*   **Versioning-based API endpoints**: You can create separate API endpoints for different versions of your resources.

## Example Usage

To use Eloquent API versioning with the `User` model, follow these steps:

1.  Install the required package using Composer: `composer require laravel/sanctum`
2.  Add the `HasApiTokens` trait to your user model.
3.  Create a new migration for the `user_versions` table.

Here is an example of how you might create the `UserVersion` model and its corresponding migration:

```php
// app/Models/UserVersion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'version_number',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

```php
// database/migrations/2023_02_15_000000_create_user_versions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserVersionsTable extends Migration
{
    public function up()
    {
        Schema::create('user_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('version_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_versions');
    }
}
```

With Eloquent API versioning, you can manage multiple versions of your resources in a single database table. This feature provides benefits such as centralized data management and easier data analysis and reporting.