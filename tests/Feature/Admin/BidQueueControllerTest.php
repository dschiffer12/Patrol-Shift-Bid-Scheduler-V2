<?php

namespace Tests\Feature\Admin;

<<<<<<< HEAD
use App\Models\Bid;
use App\Models\BiddingQueue;
use App\Models\Officer;
use App\Role;
use App\Schedule;
use App\Shift;
use App\Specialty;
use App\Spot;
use App\User;
=======
>>>>>>> c6d041a8db1085597122d0010a4d1f2e0e3b8097
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

<<<<<<< HEAD
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
=======
use Faker\Generator as Faker;

use App\Schedule;
use App\Models\BiddingQueue;
use App\User;
use App\Models\Bid;
use App\Shift;
use App\Spot;
use App\Specialty;
use App\Role;
use DateTime;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BidQueueControllerTest extends TestCase
{
    use RefreshDatabase;
    
    var $schedule;
    var $shift;
    var $spot;
    var $bid;
    var $queue;
    var $specialty;

    function setSpecialty() {
        $this->specialty = factory(Specialty::class)->create();
    }

    private function getSpecialty() {
        return $this->specialty;
    }

    function setSchedule() {
        $this->schedule = factory(Schedule::class)->create();
    }

    private function getSchedule() {
        return $this->schedule;
    }

    private function setShift() {
        $this->shift = Shift::create([
            'schedule_id' => $this->schedule->id,
            'specialty_id' => $this->specialty->id,
            'name' => 'test'
        ]);
    }

    private function getShift() {
        return $this->shift;
    }

    private function setSpot() {
        
        $this->spot = Spot::create([
            'shift_id' => $this->getShift()->id,
            'qty_available' => 2,
            'friday_s' => '00:00:00',
            'friday_e' => '08:00:00',
        ]);
    }


    private function getSpot() {
        return $this->spot;
    }
    
    private function setQueue() {
        $this->queue = BiddingQueue::create([
            'user_id' => auth()->user()->id,
            'schedule_id' => $this->getSchedule()->id,
            'bidding_spot' => 1,
            'waiting_to_bid' => false,
            'bidding' => true,
            'bid_submitted' => false
        ]);
    }

    private function getQueue() {
        return $this->queue;
    }

    private function setBid() {
        $this->bid = Bid::create([
            'user_id' => auth()->user()->id,
            'spot_id' => $this->getSpot()->id,
            'approved' => false,
            'bidding_queue_id' => $this->getQueue()->id
        ]);
    }

    private function getBid() {
        return $this->bid;
    }

    /**
     * Setup method to initialize the user that is going to be used for authentication
     *
     * @return void
     **/
    public function setUp(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        // $specialty = factory(Specialty::class)->create();
        $this->setSpecialty();
        $user->specialties()->attach($this->specialty);
        $this->actingAs($user);
        $this->setSchedule();
        $this->setShift();
        $this->setSpot();
        $this->setQueue();
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testView()
    {
        $this->setUp();
        $response = $this->get(route('admin.schedules.biddingQueue', $this->schedule->id));  
        $response->assertViewIs('admin.schedules.biddingqueue');
        $response->assertViewHas(['bidding_queue','specialties','schedule']);
    }

    public function testViewBid() {
        $this->setBid();
        $response = $this->get(route('admin.schedules.viewbid', $this->bid->id));
        $response->assertViewIs('user.schedules.viewbid');
        $response->assertViewHas(['schedule','spot','bid', 'user']);
    }

    public function testBid() {
        $response = $this->post(route('admin.schedules.bid', $this->schedule->id), [
            'user_id' => auth()->user()->id,
        ]);      
        $response->assertViewIs('user.schedules.bid');
        $response->assertViewHas(['schedule','specialties', 'user']);
    }

    public function testBidForUser() {
        $this->withoutExceptionHandling();
        $response = $this->post(route('admin.schedules.bidforuser'), [
            'user_id' => auth()->user()->id,
            'spot_id' => $this->spot->id,
            'shift_id' => $this->shift->id,
        ]);

        $response->assertRedirect('/admin/schedule/'. $this->shift->schedule_id . '/biddingQueue/');         
    }
}

>>>>>>> c6d041a8db1085597122d0010a4d1f2e0e3b8097
