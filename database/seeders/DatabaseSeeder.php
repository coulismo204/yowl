<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin 01',
            'email' => 'admin01@gmail.com',
            'password' => Hash::make('admin01@gmail.com'),
            'birthdate' => '2012-08-10',
            'admin' => 1
        ]);
    }
}
