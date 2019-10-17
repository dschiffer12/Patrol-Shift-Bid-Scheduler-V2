<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Trunkate the databse so we don;t repeat the seed
        DB::table('roles')->delete();

        Role::create(['name' => 'root']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'supervisor']);
        Role::create(['name' => 'officer']);
        Role::create(['name' => 'user']);
    }
}
