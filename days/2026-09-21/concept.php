// File: app/Database/Factories/EloquentMigrationFactory.php

namespace App\Database\Factories;

use Illuminate\Database\Migrations\MigrationFactory;
use Illuminate\Support\Facades\DB;

class EloquentMigrationFactory implements MigrationFactory
{
    public function createEloquentMigration(string $className): string
    {
        return \App\Models\{$className}::class;
    }
}

// File: app/Database/Migrations/2023_01_01_000000_create_users_table.php

namespace App\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}