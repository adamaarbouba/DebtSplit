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
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['title' => 'admin']);
        $userRole = Role::firstOrCreate(['title' => 'user']);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_id' => $adminRole->id,
        ]);

        User::factory(10)->create(['role_id' => $userRole->id])->each(function ($user) {

            $colocations = Colocation::factory(2)
                ->has(Category::factory()->count(3))
                ->create([
                    'owner_id' => $user->id,
                ]);

            foreach ($colocations as $colocation) {
                $colocation->users()->attach($user->id, [
                    'role' => 'Owner',
                    'debt' => rand(0, 100),
                    'joined_at' => now(),
                    'sold' => 0,
                ]);
            }
        });
    }
}
