<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Specialty;


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
        DB::table('users')->delete();

        // Truncate the linking table too
        DB::table('role_user')->delete();

        // Truncate the specialty_user table too
        DB::table('specialty_user')->delete();

        // Get the roles information
        $rootRole = Role::where('name', 'root')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $supervisorRole = Role::where('name', 'supervisor')->first();
        $officerRole = Role::where('name', 'officer')->first();
        $userRole = Role::where('name', 'user')->first();

        // Get the specialities information
        $btoSpecialty = Specialty::where('name', 'BTO')->first();
        $csiSpecialty = Specialty::where('name', 'CSI')->first();
        $ftsSpecialty = Specialty::where('name', 'FTS')->first();
        $ftoSpecialty = Specialty::where('name', 'FTO')->first();

        // create seed users
        $root = User::create([
            'name' => 'Root User',
            'email' => 'root@root.com',
            'password' => Hash::make('password'),
            'date_in_position' => '2000-01-01',
            'notes' =>''
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'date_in_position' => '2001-01-01',
            'notes' =>''
        ]);

        $supervisor = User::create([
            'name' => 'Supervisor User',
            'email' => 'supervisor@supervisor.com',
            'password' => Hash::make('password'),
            'date_in_position' => '2002-01-01',
            'notes' =>''
        ]);

        $officer = User::create([
            'name' => 'Officer User',
            'email' => 'officer@officer.com',
            'password' => Hash::make('password'),
            'date_in_position' => '2003-01-01',
            'notes' =>''
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'date_in_position' => '2004-01-01',
            'notes' =>''
        ]);


        // assign the roles
        $root->roles()->attach($rootRole);
        $admin->roles()->attach($adminRole);
        $supervisor->roles()->attach($supervisorRole);
        $officer->roles()->attach($officerRole);
        $user->roles()->attach($userRole);

        $root->specialties()->attach($btoSpecialty);
        $admin->specialties()->attach($csiSpecialty);
        $supervisor->specialties()->attach($ftsSpecialty);
        $officer->specialties()->attach($ftoSpecialty);
        $user->specialties()->attach($ftoSpecialty);


    }
}
