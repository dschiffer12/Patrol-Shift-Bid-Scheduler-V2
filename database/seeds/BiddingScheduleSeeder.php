<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shift;
use APP\Models\BiddingSchedule;


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


        // // Get the roles information
        // $rootRole = Role::where('name', 'root')->first();
        // $adminRole = Role::where('name', 'admin')->first();
        // $supervisorRole = Role::where('name', 'supervisor')->first();
        // $officerRole = Role::where('name', 'officer')->first();
		// $userRole = Role::where('name', 'user')->first();
		
		// // get the shifts information
		// $shiftA = Shift::where('name', 'A')->first();
		// $shiftB = Shift::where('name', 'B')->first();
		// $shiftC = Shift::where('name', 'C')->first();




        // // Get the specialities information
        // $btoSpecialty = Specialty::where('name', 'BTO')->first();
        // $csiSpecialty = Specialty::where('name', 'CSI')->first();
        // $ftsSpecialty = Specialty::where('name', 'FTS')->first();
		// $ftoSpecialty = Specialty::where('name', 'FTO')->first();
		
	
		// create schedule Quarter 1
		$Quarter12019 = BiddingSchedule::create([
			'start_day' => '2020-01-01',
			'end_day' => '2020-03-31',
			'name' => 'Fisrt Quarter 2020',
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

        // // assign the roles
        // $root->roles()->attach($rootRole);
        // $admin->roles()->attach($adminRole);
        // $supervisor->roles()->attach($supervisorRole);
        // $officer->roles()->attach($officerRole);
        // $user->roles()->attach($userRole);

        // $root->specialties()->attach($btoSpecialty);
        // $admin->specialties()->attach($csiSpecialty);
        // $supervisor->specialties()->attach($ftsSpecialty);
        // $officer->specialties()->attach($ftoSpecialty);
        // $user->specialties()->attach($ftoSpecialty);


    }
}