<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            'Admin',
            'Librarian',
            'User',
            'Student'
        ])->each(function ($role) {
            Role::create(['name' => $role, 'slug' => Str::slug($role)]);
        });
    }
}
