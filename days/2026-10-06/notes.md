# Eloquent Database Backup Strategies

Eloquent provides a simple way to manage database backups by creating a new model (`Backup`) and associating it with the user model. Here's an example of how you can implement this:

## Creating a New User Model

Firstly, we need to create a new model called `User` that extends the Eloquent model.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];

    public function backups()
    {
        return $this->hasMany(Backup::class);
    }
}
```

## Creating a New Backup Model

Next, we need to create a new model called `Backup` that also extends the Eloquent model.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Backup extends Model
{
    protected $fillable = ['user_id', 'created_at'];

    public function getUser()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
```

## Defining the Backup Relationship

We need to define a relationship between the `User` model and the `Backup` model. This can be done using the `hasMany` method.

```php
public function backups()
{
    return $this->hasMany(Backup::class);
}
```

## Testing the Backup Model

To ensure that our backup model is working correctly, we need to write some tests. Here's an example of how you can test the backup model:

```php
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_backup()
    {
        $user = factory(User::class)->create();

        $backup = $user->backups()->create(['created_at' => now()]);

        $this->assertEquals($user->id, $backup->getUser()->id);
        $this->assertEquals(now(), Carbon::parse($backup->getCreatedAt())->format('Y-m-d H:i:s'));
    }

    public function test_user_can_get_backups()
    {
        $user = factory(User::class)->create();

        $backup1 = $user->backups()->create(['created_at' => now()]);
        $backup2 = $user->backups()->create(['created_at' => Carbon::now()->subHours(1)->format('Y-m-d H:i:s')]);

        $this->assertCount(2, $user->backups);
    }

    public function test_backup_has_correct_user_id()
    {
        $user = factory(User::class)->create();

        $backup = $user->backups()->create(['created_at' => now()]);

        $this->assertEquals($user->id, $backup->getUser()->id);
    }
}
```

This example shows how you can create a backup model and associate it with the user model. It also includes some tests to ensure that the backup model is working correctly.

## Conclusion

Eloquent provides a simple way to manage database backups by creating a new model (`Backup`) and associating it with the user model. By following this example, you can implement your own Eloquent database backup strategy in Laravel.