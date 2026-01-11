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
        $user->name = "Hamdikha";
        $user->email = "khaerulhamdika999@gmail.com";
        $user->password = bcrypt("hamdika123");
        $user->phone = "087849868996";
        $user->alamat = "Jl. condong catur";
        $user->role = "admin";
        $user->foto = null;
        $user->status = "aktif";
        $user->save();
    }

    // php artisan db:seed --class=UserSeeder

}
