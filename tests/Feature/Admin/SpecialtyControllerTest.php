<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

class SpecialtyControllerTest extends TestCase
{

    use RefreshDatabase;
        
    var $schedule;
    var $shift;
    var $spot;
    var $bid;
    var $queue;
    var $specialty;
    var $addedShift;

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
    public function testIndex()
    {
        // $this->setUp();
        $response = $this->get(route('admin.specialties'));  
        $response->assertViewIs('admin.specialties.index');
        $response->assertViewHas(['specialties']);
    }

    public function testAdd() {
        $this->withoutExceptionHandling();
        $response = $this->post(route('admin.specialties.add'), [
            'name' => 'phpunittest',
        ]);

        $response->assertRedirect('/admin/specialties/');
    }


    public function testDeleteNotAssigned() {
        $this->withoutExceptionHandling();

        
        $specialt = factory(Specialty::class)->create();
        $response = $this->get(route('admin.specialties.delete', $specialt->id));

        $response->assertRedirect('/admin/specialties/');
    }


    public function testTryToDelete() {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $specialt = factory(Specialty::class)->create();
        $user->specialties()->attach($specialt);

        $response = $this->get(route('admin.specialties.delete', $specialt->id));
        $response->assertRedirect('/admin/specialties/');
    }
}
