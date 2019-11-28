<?php

namespace Tests\Feature\Admin;

use App\Models\Bid;
use App\Models\BiddingQueue;
use App\Models\Officer;
use App\Role;
use App\Schedule;
use App\Shift;
use App\Specialty;
use App\Spot;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BidQueueControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup method to initialize the user that is going to be used for authentication
     *
     * @return void
     **/
    public function setUp(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $user->roles()->attach($role);
        $this->actingAs($user);
    }

    /**
     * Test View method, return a view with some value
     *
     * @return void
    **/
    public function testVewReturnViewAndValues()
    {
        $this->setUp();

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'officer']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        factory(Officer::class)->create([ 'user_id' => 3 ]);

        //Create the BidQueue, Schedule, Spot and Shift
        factory(Schedule::class)->create([
            'start_date' => '2019-11-23',
            'end_date' => '2019-11-30',
            'currently_active' => 1,
        ]);

        factory(Shift::class)->create([
            'schedule_id' => 1,
            'specialty_id' => 1,
            'name' => 'Shift A'
        ]);

        factory(Spot::class)->create([
            'shift_id' => 1,
            'qty_available' => 2,
            'wednesday_s' => '12:00:00',
            'wednesday_e' => '20:00:00',
            'thursday_s' => '12:00:00',
            'thursday_e' => '20:00:00'

        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => 3,
            'schedule_id' => 1,
        ]);

        $response = $this->get('/admin/schedule/1/biddingQueue');

        $data = $response->getOriginalContent()->getData()['bidding_queue'];
        $scheduleID = $data[0]->schedule_id;

        $response->assertViewIs('admin.schedules.biddingqueue');
        $response->assertViewHasAll(['bidding_queue', 'specialties', 'schedule']);
        $this->assertEquals(1, $scheduleID);
    }

    /**
     * Test viewBid Method, return the view and some value to the view and in the response
     *
     * @return view
    **/
    public function testViewBidReturnViewAndValues()
    {
        $this->setUp();

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        factory(Officer::class)->create([ 'user_id' => 3 ]);

        //Create the Bid, Schedule, Spot and Shift
        factory(Schedule::class)->create([
            'start_date' => '2019-11-23',
            'end_date' => '2019-11-30',
            'currently_active' => 1,
        ]);

        factory(Shift::class)->create([
            'schedule_id' => 1,
            'specialty_id' => 1,
            'name' => 'Shift A'
        ]);

        factory(Spot::class)->create([
            'shift_id' => 1,
            'qty_available' => 2,
            'wednesday_s' => '12:00:00',
            'wednesday_e' => '20:00:00',
            'thursday_s' => '12:00:00',
            'thursday_e' => '20:00:00'

        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => 3,
            'schedule_id' => 1,
        ]);

        factory(Bid::class)->create([
            'user_id' => 3,
            'spot_id' => 1,
            'approved' => true,
            'bidding_queue_id' => 1,
        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => 3,
            'schedule_id' => 1
        ]);

        $response = $this->get('/admin/schedule/1/viewbid');

        $data = $response->getOriginalContent()->getData()['bid'];
        $bidId = $data->id;

        $response->assertViewIs('user.schedules.viewbid');
        $response->assertViewHasAll(['schedule', 'spot', 'bid', 'user']);
        $this->assertEquals(1, $bidId);
    }

    /**
     * Test bid method, return a view and values to the view
     *
     * @return void
    **/
    public function testBidReturnViewAndValues()
    {
        $this->setUp();

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        factory(Officer::class)->create([ 'user_id' => 3 ]);

        //Create the Bid, Schedule, Spot and Shift
        factory(Schedule::class)->create([
            'start_date' => '2019-11-23',
            'end_date' => '2019-11-30',
            'currently_active' => 1,
        ]);

        factory(Shift::class)->create([
            'schedule_id' => 1,
            'specialty_id' => 1,
            'name' => 'Shift A'
        ]);

        factory(Spot::class)->create([
            'shift_id' => 1,
            'qty_available' => 2,
            'wednesday_s' => '12:00:00',
            'wednesday_e' => '20:00:00',
            'thursday_s' => '12:00:00',
            'thursday_e' => '20:00:00'

        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => 3,
            'schedule_id' => 1,
        ]);

        factory(Bid::class)->create([
            'user_id' => 3,
            'spot_id' => 1,
            'approved' => true,
            'bidding_queue_id' => 1,
        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => 3,
            'schedule_id' => 1
        ]);

        $response = $this->post('/admin/schedules/1/bid', ['user_id' => 3]);

        $response->assertViewIs('user.schedules.bid');
    }

    /**
     * Test bidForUser method, return view and the bids table has one new entry.
     *
     * @return void
    **/
    public function testBidForUserReturnViewNewDBEntry()
    {
        $this->setUp();

        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        factory(Officer::class)->create([ 'user_id' => 3 ]);

        //Create the Bid, Schedule, Spot and Shift
        factory(Schedule::class)->create([
            'start_date' => '2019-11-23',
            'end_date' => '2019-11-30',
            'currently_active' => 1,
        ]);

        factory(Shift::class)->create([
            'schedule_id' => 1,
            'specialty_id' => 1,
            'name' => 'Shift A'
        ]);

        factory(Spot::class)->create([
            'shift_id' => 1,
            'qty_available' => 2,
            'wednesday_s' => '12:00:00',
            'wednesday_e' => '20:00:00',
            'thursday_s' => '12:00:00',
            'thursday_e' => '20:00:00'

        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => 3,
            'schedule_id' => 1,
        ]);

        $response = $this->post('/admin/schedules/bidforuser', ['spot_id' => 1, 'user_id' => 3, 'shift_id' => 1]);

        $bid = Bid::find(1);

        $this->assertNotEquals(0, $bid);
        $response->assertRedirect('/admin/schedule/1/biddingQueue');
    }
}
