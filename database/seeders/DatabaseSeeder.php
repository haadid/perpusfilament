<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(10)->create();
        Genre::factory()->count(5)->create();
        Author::factory()->count(7)->create();
        Category::factory()->count(5)->create();
        Publisher::factory()->count(5)->create();

        $this->call([
            RoleSeeder::class,
            BookSeeder::class
        ]);

        // assign role user(3) or student(4) to every user, user assignRole() method
        User::all()->each(function ($user) {
            $user->assignRole($role = Role::find(rand(3, 4)));
        });
    }
}
