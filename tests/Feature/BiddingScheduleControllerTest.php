<?php

namespace Tests\Feature;

use App\User;
use App\Models\BiddingQueue;
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
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));

        $this->withoutMiddleware();
        $response = $this->get('/admin/bidding-schedule/index');

        $response->assertOk();
    }

    /**
     * Assert that view return the correct list of data.
     *
     * @return void

    public function testBiddingScheduleIndexReturnValuesView()
    {
        //$this->withoutExceptionHandling();
        //$biddingSchedule = new BiddingSchedule();
        //$actualResult =  $biddingSchedule->index();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));

        $this->withoutMiddleware();
        $response = $this->get('/admin/bidding-schedule/index');

        //$response->assertViewIs('admin.biddingschedule.index');
        $response->assertViewHasAll(['biddingschedulesactive', 'biddingschedulestemplates'], );
    }**/

    /**
     * Assert one schedule stored in the database
     *
     * @return viod
    **/
    public function testStoreScheduleInDatabaseCountOne()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create(['name' => 'Admin User']));

        $this->withoutMiddleware();
        $response = $this->post('/admin/bidding-schedule', [
            'name' => 'Test Schedule',
            'start_date' => '2019-4-3',
            'end_date' => '2019-7-3',
            'response_time' => 2,
            'shiftQueue' => ["1:1"],
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

        $this->withoutMiddleware();
        $response = $this->post('/admin/bidding-schedule', [
            'name' => 'Test Schedule',
            'start_date' => '2019-4-3',
            'end_date' => '2019-7-3',
            'response_time' => 2,
            'shiftQueue' => ["1:1"],
            'officerQueue' => ["1:1"]
        ]);

        $biddingSchedule = BiddingScheduleModel::all();
        $shift = $biddingSchedule->shift();

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

        $this->withoutMiddleware();
        $response = $this->post('/admin/bidding-schedule', [
            'name' => 'Test Schedule',
            'start_date' => '2019-4-3',
            'end_date' => '2019-7-3',
            'response_time' => 2,
            'shiftQueue' => ["1:1"],
            'officerQueue' => ["1:1"]
        ]);

        $this->assertCount(1, BiddingQueue::all());
    }
}
