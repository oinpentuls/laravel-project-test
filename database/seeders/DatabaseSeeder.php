<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::where('email', 'administrator@mail.com')->first();
        if(!$admin) {
            User::create([
                'name' => 'Administrator',
                'email' => 'administrator@mail.com',
                'password' => bcrypt('password'),
                'active' => true,
                'role' => 'administrator',
            ]);
        }

        $manager = User::where('email', 'manager@mail.com')->first();
        if(!$manager) {
            User::create([
                'name' => 'Manager',
                'email' => 'manager@mail.com',
                'password' => bcrypt('password'),
                'active' => true,
                'role' => 'manager',
            ]);
        }
    }
}
