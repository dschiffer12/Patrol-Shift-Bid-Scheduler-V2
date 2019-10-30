<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shift;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Trunkate the databse so we don't repeat the seed
        DB::table('shifts')->delete();

        Shift::create([
            'name' => 'A',
            'start_time' => '06:00:00',
            'end_time' => '14:00:00',
            'minimun_staff' => '5',
        ]);

        Shift::create([
            'name' => 'B',
            'start_time' => '14:00:00',
            'end_time' => '22:00:00',
            'minimun_staff' => '5',
        ]);

        Shift::create([
            'name' => 'C',
            'start_time' => '22:00:00',
            'end_time' => '06:00:00',
            'minimun_staff' => '5',
        ]);

        // factory(Shift::class, 3)->create();


    }
}
