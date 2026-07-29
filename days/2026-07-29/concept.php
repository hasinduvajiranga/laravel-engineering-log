// models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    public function usersWithCursor()
    {
        $users = DB::table('users')
            ->cursor(function ($row) {
                return [
                    'id' => $row['id'],
                    'name' => $row['name'],
                ];
            })
            ->get();

        foreach ($users as $user) {
            echo "ID: {$user['id']}, Name: {$user['name']}\n";
        }
    }

    public function usersWithForCursor()
    {
        $users = DB::table('users')
            ->forCursor(function ($row) {
                return [
                    'id' => $row['id'],
                    'name' => $row['name'],
                ];
            })
            ->get();

        foreach ($users as $user) {
            echo "ID: {$user['id']}, Name: {$user['name']}\n";
        }
    }

    public function usersWithSkipCursor()
    {
        $users = DB::table('users')
            ->skip(2)
            ->cursor(function ($row) {
                return [
                    'id' => $row['id'],
                    'name' => $row['name'],
                ];
            })
            ->get();

        foreach ($users as $user) {
            echo "ID: {$user['id']}, Name: {$user['name']}\n";
        }
    }

    public function usersWithLimitCursor()
    {
        $users = DB::table('users')
            ->limit(3)
            ->cursor(function ($row) {
                return [
                    'id' => $row['id'],
                    'name' => $row['name'],
                ];
            })
            ->get();

        foreach ($users as $user) {
            echo "ID: {$user['id']}, Name: {$user['name']}\n";
        }
    }
}