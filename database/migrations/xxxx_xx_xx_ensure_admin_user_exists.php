<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EnsureAdminUserExists extends Migration
{
    public function up()
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);
        }
    }

    public function down()
    {
        User::where('email', 'admin@gmail.com')->delete();
    }
}
