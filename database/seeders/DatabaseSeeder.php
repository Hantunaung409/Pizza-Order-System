<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       User::create([
        'name' => 'Han Tun Aung',
        'email' => 'hanhtunaung409@gmail.com',
        'phone' => '09260697933',
        'address' => 'Waing Maw',
        'role' => 'admin',
        'gender' => 'male',
        'password' => Hash::make('AdminHan')
       ]);
    }
}
