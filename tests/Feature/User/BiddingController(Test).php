<?php

namespace Tests\Feature\User;

use App\Models\Bid;
use App\Models\BiddingQueue;
use App\Models\BiddingSchedule;
use App\Models\BidEarlyShift;
use App\Models\EarlyShift;
use App\Models\Shift;
use Mockery;
use App\Role;
use App\User;
use Tests\TestCase;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiddingControllerTest extends TestCase
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
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
    }

    /**
     * Assert the Index method return veiw if it doen't have any Bidding Queue
     *
     * @return void
    **/
    public function testIndexReturnView()
    {
        $this->setUp();

        $user = factory(User::class)->create();
        $biddingSchedule = factory(BiddingSchedule::class)->create();
        $biddingQueue = factory(BiddingQueue::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $biddingSchedule->id
        ]);

        $response = $this->get('/user/biddingschedule');

        $response->assertViewIs('user.bidding');
    }

    /**
     * Assert the Index method return veiw if it has any Bidding Queue
     *
     * @return void
     **/
    public function testIndexReturnValueToView()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $biddingSchedule = factory(BiddingSchedule::class)->create();
        factory(BiddingQueue::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $biddingSchedule->id,
            'bidding_spot' => 1,
            'bidding' => 1,
            'waiting_to_bid' => 0,
            'bid_submitted' => 0
        ]);

        $response = $this->get('/user/biddingschedule');

        $response->assertViewIs('user.bidding');
    }

    /**
     * Assert that a new Bid as created int the Bid table and the user bidded successfully. Also that redirected to
     * /user/biddingschedule/bids
     *
     * @return void
    **/
    public function testStoreBidTableWithCount()
    {
        Event::fake();

        $this->withoutExceptionHandling();
        //User 1
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        //User 2
        $user2 = factory(User::class)->create();
        $role2 = factory(Role::class)->create(['name' => 'officer']);
        $user2->roles()->attach($role2);

        $shift = factory(Shift::class)->create();

        $earlyShift = factory(EarlyShift::class)->create([
            'shift_id' => $shift->id
        ]);

        $schedule = factory(BiddingSchedule::class)->create();
        $schedule->shift()->attach($shift->id);

        factory(BiddingQueue::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
            'bidding_spot' => 1,
            'bidding' => 1,
            'waiting_to_bid' => 0,
            'bid_submitted' => 0
        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => $user2->id,
            'bidding_schedule_id' => $schedule->id,
            'bidding_spot' => 2,
            'bidding' => 0,
            'waiting_to_bid' => 1,
            'bid_submitted' => 0
        ]);

        $response = $this->post('/user/biddingschedule', [
            'shift_id' => $shift->id,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
            'early_shift' => 1,
            'e_friday' => 1,
            'e_saturday' => 1,
            'e_sunday' => 1,
            'e_monday' => 1,
            'e_tuesday' => 1,
            'e_wednesday' => 1,
            'e_thursday' => 1,
            'schedule_id' => $schedule->id,
        ]);

        $bid = Bid::all();
        $this->assertCount(1, $bid);

        $response->assertRedirect('/user/biddingschedule/bids');
    }

    /**
     * Test case on Store method for when a authenticated user has bidded already.
     *
     * @return void
    **/
    public function testStoreUserHasBidded()
    {
        Event::fake();

        $this->withoutExceptionHandling();
        //User 1
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $shift = factory(Shift::class)->create();

        $earlyShift = factory(EarlyShift::class)->create([
            'shift_id' => $shift->id
        ]);

        $schedule = factory(BiddingSchedule::class)->create();
        $schedule->shift()->attach($shift->id);

        factory(BiddingQueue::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
            'bidding_spot' => 1,
            'bidding' => 0,
            'waiting_to_bid' => 0,
            'bid_submitted' => 1
        ]);

        factory(Bid::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
            'shift_id' => $shift->id,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
        ]);

        $response = $this->post('/user/biddingschedule', [
            'shift_id' => $shift->id,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
            'early_shift' => 1,
            'e_friday' => 1,
            'e_saturday' => 1,
            'e_sunday' => 1,
            'e_monday' => 1,
            'e_tuesday' => 1,
            'e_wednesday' => 1,
            'e_thursday' => 1,
            'schedule_id' => $schedule->id,
        ]);

        $response->assertRedirect('/user/biddingschedule');
    }

    /**
     * Assert Show method return user.bidding view
     *
     * @return void

    public function testShowReturnView()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $shift = factory(Shift::class)->create();

        $earlyShift = factory(EarlyShift::class)->create([
            'shift_id' => $shift->id
        ]);

        $schedule = factory(BiddingSchedule::class)->create();
        $schedule->shift()->attach($shift->id);

        factory(BiddingQueue::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
            'bidding_spot' => 1,
            'bidding' => 1,
            'waiting_to_bid' => 0,
            'bid_submitted' => 0
        ]);

        $response = $this->get('/user/biddingschedule/1', ['schedule_id' => $schedule->id]);

        //$response->assertViewIs('user.bidding');
        //$response->assertViewHasAll(['schedule', 'shifts', 'schedules']);
        $response->assertOk();
    }**/

    /**
     * Assert Bid method return a user.bids view without bid_id parameter in Request
     *
     * @return void
    **/
    public function testBidWithoutBidReturnViewandValue()
    {
        $this->withoutExceptionHandling();
        //User 1
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get(route('user.biddingschedule.bids'));

        $response->assertViewIs('user.bids');
        $response->assertViewHas('warning');
    }

    /**
     * Assert Bid method return a user.bids view without bid_id parameter in Request
     *
     * @return void
     **/
    public function testBidWithBidReturnViewAndValue()
    {
        $this->withoutExceptionHandling();
        //User 1
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $shift = factory(Shift::class)->create();

        $earlyShift = factory(EarlyShift::class)->create([
            'shift_id' => $shift->id
        ]);

        $schedule = factory(BiddingSchedule::class)->create();
        $schedule->shift()->attach($shift->id);

        factory(Bid::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
            'shift_id' => $shift->id,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
        ]);

        $response = $this->get(route('user.biddingschedule.bids', ['bid_id' => 1]));

        $response->assertViewIs('user.bids');
        $response->assertViewHas('schedules');
    }

    /**
     * Assert Bid method return view user.bids with value
     * 'schedules'
     * 'bid'
     * 'schedule'
     * 'shift'
     * 'bid_early_shift'
     * 'early_shift'
     *
     * @return void
    **/
    public function testBidsWithEarlyShiftReturnViewWithValue()
    {
        $this->withoutExceptionHandling();
        //User 1
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $shift = factory(Shift::class)->create();

        $earlyShift = factory(EarlyShift::class)->create([
            'shift_id' => $shift->id
        ]);

        $schedule = factory(BiddingSchedule::class)->create();
        $schedule->shift()->attach($shift->id);

        $bid = factory(Bid::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
            'shift_id' => $shift->id,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
        ]);

        factory(BidEarlyShift::class)->create([
            'bid_id' => $bid->id,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
        ]);

        $response = $this->get(route('user.biddingschedule.bids', ['bid_id' => 1]));

        $response->assertViewIs('user.bids');
        $response->assertViewHasAll(['schedules','bid','schedule','shift','bid_early_shift','early_shift']);
    }

    /**
     * Assert Bids method return view user.bids and values schedules and 'warning'
     *
     * @return void

    public function testBidsWithDifferentShiftReturnViawAndValue()
    {
        $this->withoutExceptionHandling();
        //User 1
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $shift = factory(Shift::class)->create();
        $shift2 = factory(Shift::class)->create();

        $earlyShift = factory(EarlyShift::class)->create([
            'shift_id' => $shift->id
        ]);

        $schedule = factory(BiddingSchedule::class)->create();
        $schedule->shift()->attach($shift->id);

        $bid = factory(Bid::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
            'shift_id' => 2,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
        ]);

        $response = $this->get(route('user.biddingschedule.bids', ['bid_id' => 1]));

        $response->assertViewIs('user.bids');
        $response->assertViewHasAll(['schedules','warning']);
    }**/
}
