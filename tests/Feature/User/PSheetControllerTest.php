<?php

namespace Tests\Feature\User;

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

class PSheetControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup method to initialize the user Admin that is going to be used for authentication
     *
     * @return void
     **/
    public function setUpAdmin(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        factory(Officer::class)->create([ 'user_id' => 1 ]);

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
            'user_id' => 1,
            'schedule_id' => 1,
        ]);

        factory(Bid::class)->create([
            'user_id' => 1,
            'spot_id' => 1,
            'approved' => true,
            'bidding_queue_id' => 1,
        ]);

        $this->actingAs($user);
    }

    /**
     * Setup method to initialize the user Admin that is going to be used for authentication
     *
     * @return void
     **/
    public function setUpOfficer(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'officer']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        factory(Officer::class)->create([ 'user_id' => 1 ]);

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
            'wednesday_s' => '20:00:00',
            'thursday_s' => '12:00:00',
            'thursday_e' => '20:00:00'
        ]);

        factory(BiddingQueue::class)->create([
            'user_id' => 1,
            'schedule_id' => 1,
        ]);

        factory(Bid::class)->create([
            'user_id' => 1,
            'spot_id' => 1,
            'approved' => true,
            'bidding_queue_id' => 1,
        ]);

        $this->actingAs($user);
    }

    /**
     * With the user Admin, test that the response is returning an view and the view has all the specific values.
     *
     * @return void
     */
    public function testIndexReturnViewAsAdmin()
    {
        $this->setUpAdmin();

        $response = $this->get('/user/psheet/today');

        $data = $response->getOriginalContent()->getData()['shifts'];

        $response->assertViewIs('user.psheet');
        $response->assertViewHasAll(['editable', 'spots', 'weekday', 'shifts', 'daySelected']);
    }

    /**
     * With the user Officer, test that the index method response is returning an view and the view
     * has all the specific values.
     *
     * @return void
     */
    public function testIndexReturnViewAsOfficer()
    {
        $this->setUpOfficer();

        $response = $this->get('/user/psheet/today');

        $data = $response->getOriginalContent()->getData()['shifts'];

        $response->assertViewIs('user.psheet');
        $response->assertViewHasAll(['spots', 'weekday', 'shifts', 'daySelected']);
    }

    /**
     * With the user Admin, test that the date() method response is returning an view and the view
     * has all the specific values.
     *
     * @return void
     */
    public function testDateReturnViewAsAdmin()
    {
        $this->setUpAdmin();

        $response = $this->post('/user/psheet/date', ['calendar_date' =>'2019-11-27']);

        $response->assertViewIs('user.psheet');
        $response->assertViewHasAll(['editable', 'spots', 'weekday', 'shifts', 'daySelected']);
    }

    /**
     * With the user Officer, test that the date() method response is returning an view and the view
     * has all the specific values.
     *
     * @return void
     */
    public function testDateReturnViewAsOfficer()
    {
        $this->setUpOfficer();

        $response = $this->post('/user/psheet/date', ['calendar_date' =>'2019-11-29']);

        $response->assertViewIs('user.psheet');
        $response->assertViewHasAll(['spots', 'weekday', 'shifts', 'daySelected']);
    }

    /**
     * With the user Admin, test that the date() method response is returning an view and the view
     * has all the specific values.
     *
     * @return void
     */
    public function testDateReturnViewAsAdminWithoutBids()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        $this->actingAs($user);

        $response = $this->post('/user/psheet/date', ['calendar_date' =>'2019-11-27']);

        $data = $response->getOriginalContent()->getData()['shifts'];

        $response->assertViewIs('user.psheet');
        $response->assertViewHas(['noSpots']);
        $this->assertCount(0, $data);
    }

    /**
     * With the user Officer, test that the date() method response is returning an view and the view
     * has all the specific values.
     *
     * @return void
     */
    public function testDateReturnViewAsOfficerWithoutBids()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'officer']);
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        $this->actingAs($user);

        $response = $this->post('/user/psheet/date', ['calendar_date' =>'2019-11-27']);

        $data = $response->getOriginalContent()->getData()['shifts'];

        $response->assertViewIs('user.psheet');
        $response->assertViewHas(['noSpots']);
        $this->assertCount(0, $data);
    }
}
