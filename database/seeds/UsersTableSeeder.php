<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the databse so we don't repeat the seed
        User::truncate();

        // Truncate the linking table too
        DB::table('role_user')->truncate();

        // Get the roles information
        $rootRole = Role::where('name', 'root')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $supervisorRole = Role::where('name', 'supervisor')->first();
        $officerRole = Role::where('name', 'officer')->first();
        $userRole = Role::where('name', 'user')->first();

        // create seed users
        $root = User::create([
            'name' => 'Root User',
            'email' => 'root@root.com',
            'password' => Hash::make('password')
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $supervisor = User::create([
            'name' => 'Supervisor User',
            'email' => 'supervisor@supervisor.com',
            'password' => Hash::make('password')
        ]);

        $officer = User::create([
            'name' => 'Officer User',
            'email' => 'officer@officer.com',
            'password' => Hash::make('password')
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password')
        ]);


        // assign the roles
        $root->roles()->attach($rootRole);
        $admin->roles()->attach($adminRole);
        $supervisor->roles()->attach($supervisorRole);
        $officer->roles()->attach($officerRole);
        $user->roles()->attach($userRole);

    }
}
