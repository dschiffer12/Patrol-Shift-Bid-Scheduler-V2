<?php

use Illuminate\Database\Seeder;
use App\Models\EarlyShift;

class EarlyShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EarlyShift::class, 3)->create();
    }
}
