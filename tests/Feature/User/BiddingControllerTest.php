<?php

namespace Tests\Feature\User;

use App\Models\BiddingQueue;
use App\Models\BiddingSchedule;
use App\Models\EarlyShift;
use App\Models\Shift;
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
     * Assert that a new Bid as created int the Bid table and the user bidded successfully
     *
     * @return void
    **/
    public function testStoreBidTableWithCount()
    {
        Event::fake();

        $this->withoutExceptionHandling();
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

        $biddingQueue = factory(BiddingQueue::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $schedule->id,
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

        $response->assertRedirect('user.biddingschedule.bids');
    }
}
