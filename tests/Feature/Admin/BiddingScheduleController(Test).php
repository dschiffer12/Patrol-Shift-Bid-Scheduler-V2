<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Models\Shift;
use App\Models\BiddingQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Admin\BiddingSchedule;
use App\Models\BiddingSchedule as BiddingScheduleModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BiddingScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Make sure that no authenticated users have access to see Bidding Schedule page.
     *
     * @return void
     */
    public function testUnloggedUsersCanNotSeeSchedules()
    {
        $response = $this->get('/admin/bidding-schedule/index');

        $response->assertRedirect('/login');
    }

    /**
     * Only root or admin users can access Bidding Schedule page.
     *
     * @return void
    **/
    public function testAuthUsersRootAdminAccessSchedule()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get('/admin/bidding-schedule');

        $response->assertOk();
    }

    /**
     * Assert that view return the correct list of data.
     *
     * @return void
     **/
    public function testBiddingScheduleIndexReturnValuesView()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get('/admin/bidding-schedule');

        //$response->assertViewIs('admin.biddingschedule.index');
        $response->assertViewHasAll(['biddingschedulesactive', 'biddingschedulestemplates'] );
    }

    /**
     * Assert that view return the correct list of data.
     *
     * @return void
     **/
    public function testBiddingScheduleCreateReturnValuesView()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);

        $this->actingAs($user)
            ->get(route('admin.bidding-schedule.create'))
            ->assertViewHasAll(['users', 'shifts'] );
    }

    /**
     * Assert one schedule stored in the database
     *
     * @return viod
    **/
    public function testStoreScheduleInDatabaseCountOne()
    {
        Event::fake();

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        factory(Shift::class)->create();

        $response = $this->post('/admin/bidding-schedule', [
            'name' => 'Test Schedule',
            'start_date' => '2020-4-3',
            'end_date' => '2020-7-3',
            'response_time' => 2,
            'save_as_template' => true,
            'currently_active' => true,
            'shiftQueue' => ["1:on"],
            'officerQueue' => ["1:1"]

        ]);

        $this->assertCount(1, BiddingScheduleModel::all());
    }

    /**
     * Assert one Shift stored in the database once the schedule is saved in database
     *
     * @return viod
     **/
    public function testStoreShiftOnScheduleInDatabaseCountOne()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));
        factory(Shift::class)->create();

        $this->withoutMiddleware();
        $response = $this->post('/admin/bidding-schedule', [
            'name' => 'Test Schedule',
            'start_date' => '2020-4-3',
            'end_date' => '2020-7-3',
            'response_time' => 2,
            'save_as_template' => true,
            'currently_active' => true,
            'shiftQueue' => ["1:on"],
            'officerQueue' => ["1:1"]
        ]);

        $shift = DB::select('select * from bidding_schedule_shift');

        $this->assertCount(1, $shift);
    }

    /**
     * Assert one Bidding Queue stored in the database once the schedule is saved in database
     *
     * @return viod
     **/
    public function testStoreQueueOnScheduleInDatabaseCountOne()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));
        factory(Shift::class)->create();

        $this->withoutMiddleware();
        $response = $this->post('/admin/bidding-schedule', [
            'name' => 'Test Schedule',
            'start_date' => '2020-4-3',
            'end_date' => '2020-7-3',
            'response_time' => 2,
            'save_as_template' => true,
            'currently_active' => true,
            'shiftQueue' => ["1:on"],
            'officerQueue' => ["1:1"]
        ]);

        $this->assertCount(1, BiddingQueue::all());
    }


    /**
     * Assert one schedule update in the database
     *
     * @return viod
     **/
    public function testUpdateScheduleInDatabaseCountOne()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));
        factory(BiddingScheduleModel::class)->create();
        factory(Shift::class)->create();

        $this->withoutMiddleware();
        $response = $this->put('/admin/bidding-schedule/1', [
            'name' => 'Test Schedule 2',
            'start_date' => '2020-4-2',
            'end_date' => '2020-7-3',
            'response_time' => 2,
            'save_as_template' => true,
            'currently_active' => true,
            'shiftQueue' => ["1:on"],
            'officerQueue' => ["1:1"]

        ]);

        $biddingSchedule = DB::select('select * from bidding_schedules where name = "Test Schedule 2"');

        $this->assertCount(1, $biddingSchedule);
    }

    /**
     * Assert one Shift update in the database once the schedule is saved in database
     *
     * @return viod
     **/
    public function testUpdateShiftOnScheduleInDatabaseCountOne()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));
        factory(Shift::class)->create();
        factory(BiddingScheduleModel::class)->create();
        /*$newBiddingSchedule->shift()->createMany(
            factory(Shift::class, 1)->make()->toArray()
        );*/

        $this->withoutMiddleware();
        $response = $this->put('/admin/bidding-schedule/1', [
            'name' => 'Test Schedule',
            'start_date' => '2020-4-3',
            'end_date' => '2020-7-3',
            'response_time' => 2,
            'save_as_template' => true,
            'currently_active' => true,
            'shiftQueue' => ["1:checked"],
            'officerQueue' => ["1:1"]
        ]);

        $shift = DB::select('select * from bidding_schedule_shift');

        $this->assertCount(1, $shift);
    }

    /**
     * Assert one Bidding Queue update in the database once the schedule is saved in database
     *
     * @return viod
     **/
    public function testUpdateQueueOnScheduleInDatabaseCountOne()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));
        factory(Shift::class)->create();
        factory(BiddingScheduleModel::class)->create();

        $this->withoutMiddleware();
        $response = $this->put('/admin/bidding-schedule/1', [
            'name' => 'Test Schedule',
            'start_date' => '2020-4-3',
            'end_date' => '2020-7-3',
            'response_time' => 2,
            'save_as_template' => true,
            'currently_active' => true,
            'shiftQueue' => ["1:on"],
            'officerQueue' => ["1:1"]
        ]);

        $this->assertCount(1, BiddingQueue::all());
    }

    /**
     * Assert that bidding schedule, shift, and bidding queue are deleted
     *
     * @return void
    **/
    public function testBiddingScheduleShiftQueueDelete ()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));
        $user = User::all();
        factory(Shift::class)->create();
        factory(BiddingScheduleModel::class)->create();
        $schedule = BiddingScheduleModel::all();
        factory(BiddingQueue::class)->create([
            'user_id' => $user[0]->id,
            'bidding_schedule_id' => $schedule[0]->id,
        ]);

        $this->withoutMiddleware();
        $this->delete(route('admin.bidding-schedule.destroy', $schedule[0]));

        $schedule = BiddingScheduleModel::all();
        $shift = DB::select('select * from bidding_schedule_shift');
        $queue = BiddingQueue::all();

        //Deleted in Bidding Schedule Shift Pivot table
        $shift = DB::select('select * from bidding_schedule_shift');
        $this->assertCount(0, $shift);

        //Deleted in the Bidding Queue Table
        $this->assertCount(0, BiddingQueue::all());

        //Deleted in Bidding Schedule Table
        $this->assertCount(0, BiddingScheduleModel::all());
    }

    /**
     * Test bidding schedule edit method that return the correct key.
     *
     * @return void
     **/
    public function testBiddingScheduleEditReturnKey()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        $biddingSchedule = factory(BiddingScheduleModel::class)->create();
        $shift = factory(Shift::class)->create();
        $biddingSchedule->shift()->attach($shift);


        $responce = $this->get(route('admin.bidding-schedule.edit', 1));

        $responce->assertViewHasAll(['shifts', 'biddingschedule', 'users']);
    }
}
