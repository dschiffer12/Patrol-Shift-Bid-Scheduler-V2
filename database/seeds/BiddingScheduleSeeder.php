<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shift;
use App\Models\BiddingSchedule;


class BiddingScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the databse so we don't repeat the seed
        DB::table('bidding_schedules')->delete();

        // Truncate the linking table too
        DB::table('bidding_schedule_shift')->delete();
		
	
		// create schedule Quarter 1
		$Quarter12019 = BiddingSchedule::create([
			'start_day' => '2020-01-01',
			'end_day' => '2020-03-31',
			'name' => 'Fisrt Quarter 2020',
			'response_time' => '2',
			'save_as_template' => '0',
			'currently_active' => '1',
        ]);

        // create schedule Quarter 2
		$Quarter22019 = BiddingSchedule::create([
			'start_day' => '2020-04-01',
			'end_day' => '2020-07-31',
			'name' => 'Second Quarter 2020',
			'response_time' => '2',
			'save_as_template' => '0',
			'currently_active' => '1',
		]);

		$ShiftA = Shift::where('name', 'A')->first();
		$ShiftB = Shift::where('name', 'B')->first();
		$ShiftC = Shift::where('name', 'C')->first();

		$Quarter12019->shifts()->attach($ShiftA);
		$Quarter12019->shifts()->attach($ShiftB);
        $Quarter12019->shifts()->attach($ShiftC);
        
        $Quarter12019->shifts()->attach($ShiftA);
		$Quarter12019->shifts()->attach($ShiftB);
		$Quarter12019->shifts()->attach($ShiftC);

    }
}