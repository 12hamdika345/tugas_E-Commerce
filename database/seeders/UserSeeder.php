<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->name = "Admin";
        $user->email = "admin@example.com";
        $user->password = bcrypt("password");
        $user->phone = "1234567890";
        $user->alamat = "Jl. Contoh Alamat No. 123";
        $user->role = "admin";
        $user->foto = null;
        $user->status = "aktif";
        $user->save();
    }

    // php artisan db:seed --class=UserSeeder

}
