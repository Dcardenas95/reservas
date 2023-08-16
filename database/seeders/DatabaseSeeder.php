<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'staff']);
        Role::create(['name' => 'client']);

        $usersClient = \App\Models\User::factory(10)->create();

        foreach ($usersClient as $user) {
            $user->assignRole('client');
        }

        $userAdmin = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        
        $userAdmin->assignRole('admin');

        $userStaff = \App\Models\User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
        ]);
        $userStaff->assignRole('staff');

        $userStaff = \App\Models\User::factory()->create([
            'name' => 'david',
            'email' => 'david@example.com',
        ]);
        $userStaff->assignRole('staff');
        
        $userStaff = \App\Models\User::factory()->create([
            'name' => 'paco',
            'email' => 'paco@example.com',
        ]);
        $userStaff->assignRole('staff');


        $this->call(OpeningHoursSeeder::class);
        $this->call(ServicesSeeder::class);

    }
}
