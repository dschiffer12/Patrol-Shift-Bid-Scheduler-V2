<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

class ScheduleControllerTest extends TestCase
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
        $this->setUp();
        $response = $this->get(route('admin.schedules.index'));  
        $response->assertViewIs('admin.schedules.index');
        $response->assertViewHas(['schedules']);
    }

    public function testCreate()
    {
        $response = $this->get(route('admin.schedules.create'));  
        $response->assertViewIs('admin.schedules.create');
    }

    public function testStore()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('admin.schedules.store'), [
            'schedule_name' => 'phpunitstore',
            'start_date' => $this->schedule->start_date,
            'end_date' => $this->schedule->end_date,
            'response_time' => $this->schedule->response_time,
        ]);

        $schedule2 = Schedule::where('name', 'phpunitstore')->first();

        $response->assertRedirect('/admin/schedules/'. $schedule2->id .'/edit/'); 
    }

    public function testEdit()
    {
        $response = $this->get(route('admin.schedules.edit', $this->schedule->id));  
        $response->assertViewIs('admin.schedules.edit');
        $response->assertViewHas(['schedule', 'specialties']);
    }

    public function testAddShift()
    {
        $response = $this->post(route('admin.schedules.addShift', $this->schedule->id), [
            'shift_name' => 'phpunit-A',
            'schedule_id' => $this->schedule->id,
            'specialty_id' => $this->specialty->id,
        ]);

        $response->assertRedirect('/admin/schedules/'. $this->schedule->id .'/edit/');
    }


    public function testAddSpot()
    {
        $this->addedShift = Shift::create([
            'schedule_id' => $this->schedule->id,
            'specialty_id' => $this->specialty->id,
            'name' => 'test-A'
        ]);

        $response = $this->post(route('admin.schedules.addSpot', $this->schedule->id), [
            'shift_id' => $this->addedShift->id,
            'qty_available' => 4,
        ]);

        $response->assertRedirect('/admin/schedules/'. $this->schedule->id .'/edit/');
    }


    public function testUser()
    {
        $response = $this->get(route('admin.schedules.addUsers', $this->schedule->id));  
        $response->assertViewIs('admin.schedules.addusers');
        $response->assertViewHas(['schedule', 'specialties', 'users']);
    }


    public function testStoreQueue() {

        $specialties = Specialty::all();
        $allSpecialties[$this->specialty->id][auth()->user()->id] = 1;
        
        $response = $this->post(route('admin.schedules.storeQueue', $this->schedule->id), [
            'allSpecialties' => $allSpecialties,
        ]);

        $response->assertRedirect('/admin/schedules/'. $this->schedule->id .'/reviewSchedule/');
    }
    

    public function testDeleteSpot() {      
        $response = $this->post(route('admin.schedules.deleteSpot', $this->schedule->id), [
            'spot_id' => $this->spot->id,
        ]);

        $response->assertRedirect('/admin/schedules/'. $this->schedule->id .'/edit/');
    }

    public function testDeleteShift() {      
        $response = $this->post(route('admin.schedules.deleteShift', $this->schedule->id), [
            'shift_id' => $this->shift->id,
        ]);

        $response->assertRedirect('/admin/schedules/'. $this->schedule->id .'/edit/');
    }

    public function testReviewSchedule()
    {
        $response = $this->get(route('admin.schedules.reviewSchedule', $this->schedule->id));  
        $response->assertViewIs('admin.schedules.reviewschedule');
        $response->assertViewHas(['schedule', 'specialties', 'bidding_queue']);
    }


    public function testActivateSchedule()
    {
        $response = $this->get(route('admin.schedules.activateSchedule', $this->schedule->id));  
        $response->assertRedirect('/admin/schedules/');
    }


    public function testApproveSchedule()
    {
        $response = $this->get(route('admin.schedules.approveSchedule', $this->schedule->id));  
        $response->assertViewIs('admin.schedules.approveschedule');
        $response->assertViewHas(['schedule', 'specialties']);
    }


    public function testSaveApproval() {      
        $response = $this->post(route('admin.schedules.saveApproval'), [
            'schedule_id' => $this->schedule->id,
        ]);

        $response->assertRedirect('/admin/schedules/');
    }


    public function testViewApproval()
    {
        $response = $this->get(route('admin.schedules.viewApproved', $this->schedule->id));  
        $response->assertViewIs('admin.schedules.approveschedule');
        $response->assertViewHas(['schedule', 'specialties', 'view_approval']);
    }

}
