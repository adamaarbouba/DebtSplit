<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    // database/seeders/DatabaseSeeder.php
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['title' => 'admin']);
        $userRole = Role::firstOrCreate(['title' => 'user']);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_id' => $adminRole->id,
        ]);

        User::factory(10)
            ->hasAttached(
                Colocation::factory()
                    ->count(2)
                    ->has(Category::factory()->count(3)),
                [
                    'role' => 'member',
                    'debt' => rand(0, 100),
                    'joined_at' => now()
                ]
            )
            ->create([
                'role_id' => $userRole->id
            ]);
    }
}
