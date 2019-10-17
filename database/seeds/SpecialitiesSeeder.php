<?php

use Illuminate\Database\Seeder;
use App\Specialty;

class SpecialitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Trunkate the databse so we don't repeat the seed
        DB::table('specialties')->delete();

        Specialty::create(['name' => 'BTO']);
        Specialty::create(['name' => 'CSI']);
        Specialty::create(['name' => 'FTS']);
        Specialty::create(['name' => 'FTO']);
    }
}
