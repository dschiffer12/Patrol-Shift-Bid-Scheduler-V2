<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use App\Models\Shift;
use App\Models\EarlyShift;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Make sure that no authenticated users have access to see Shift list page.
     *
     * @return void
     */
    public function testUnloggedUsersCanNotSeeShift()
    {
        $response = $this->get('/admin/shift/index');

        $response->assertRedirect('/login');
    }

    /**
     * Only root or admin users can access Shift list page.
     *
     * @return void
     **/
    public function testAuthUsersRootAdminAccessSchedule()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get('/admin/shift');

        $response->assertOk();
    }

    /**
     * Assert that Shift Index method in ShiftController return the correct list of data to the view.
     *
     * @return void
     **/
    public function testShiftIndexReturnValuesView()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get('/admin/shift');

        //$response->assertViewIs('admin.biddingschedule.index');
        $response->assertViewHasAll(['shifts'] );
    }

    /**
     * Assert that view return the correct list of data.
     *
     * @return void
     **/
    public function testShiftCreateReturnValuesView()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);

        $this->actingAs($user)
            ->get(route('admin.shift.create'))
            ->assertViewIs('admin.shift.create_shift');
    }

    /**
     * Test that a shift gets store in the database
     *
     * @return void
    **/
    public function testShiftStoreShiftRecordInDB()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $this->post('/admin/shift', [
            'name' => 'Shift T',
            'start_time' => '8:00:00',
            'end_time' => '17:00:00',
            'minimun_staff' => 5
        ]);

        $this->assertCount(1, Shift::all());
    }

    /**
     * Test that a early shift gets store in the database
     *
     * @return void
     **/
    public function testShiftStoreEarlyShiftRecordInDB()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $this->post('/admin/shift', [
            'name' => 'Shift T',
            'start_time' => '8:00:00',
            'end_time' => '17:00:00',
            'minimun_staff' => 5,
            'early_start_time' => '7:00:00',
            'early_end_time' => '16:00:00',
            'num_early_spot' => '2'
        ]);

        $this->assertCount(1, EarlyShift::all());
    }

    /**
     * Assert that CreateFromSchedule method return the correct view.
     *
     * @return void
     **/
    public function testShiftCreateFromScheduleReturnValuesView()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);

        $this->actingAs($user)
            ->get(route('admin.shift.createFromSchedule'))
            ->assertViewIs('admin.shift.create_shift_from_schedule');
    }

    /**
     * Test that a shift created from bidding schedule gets store in the database
     *
     * @return void
     **/
    public function testShiftStoreFromScheduleShiftRecordInDB()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $this->post('/admin/shift/storeFromSchedule', [
            'name' => 'Shift T',
            'start_time' => '8:00:00',
            'end_time' => '17:00:00',
            'minimun_staff' => 5
        ]);

        $this->assertCount(1, Shift::all());
    }

    /**
     * Test that a early shift gets store in the database
     *
     * @return void
     **/
    public function testShiftStoreEarlyShiftFromScheduleRecordInDB()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $responce = $this->post('/admin/shift/storeFromSchedule', [
            'name' => 'Shift T',
            'start_time' => '8:00:00',
            'end_time' => '17:00:00',
            'minimun_staff' => 5,
            'early_start_time' => '7:00:00',
            'early_end_time' => '16:00:00',
            'num_early_spot' => '2'
        ]);

        $this->assertCount(1, EarlyShift::all());
        $responce->assertRedirect('/admin/bidding-schedule/create');
    }

    /**
     * Test shift edit method that return the correct key.
     *
     * @return void
    **/
    public function testShiftEditReturnKey()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        factory(Shift::class)->create();

        $responce = $this->get(route('admin.shift.edit', 1));

        $responce->assertViewHas('shift');
    }

    /**
     * Test update shift and assert value is in database view
     *
     * @param $id
     * @return
    **/
    public function testShitUpdateValueIsInDB()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        factory(Shift::class)->create();

        $this->put('/admin/shift/1', [
            'name' => 'Shift T',
            'start_time' => '8:00:00',
            'end_time' => '17:00:00',
            'minimun_staff' => 5,
            'early_start_time' => '7:00:00',
            'early_end_time' => '16:00:00',
            'num_early_spot' => '2'
        ]);

        $shift = DB::select('select * from shifts where id = 1');
        $this->assertEquals('Shift T', $shift[0]->name);
    }

    /**
     * Test update shift early from bidding schedule assert equals to the value in the database
     *
     * @param shift $id
     * @return vois
    **/
    public function testShiftEarlyFromBiddingScheduleIsValueInDB()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        $shift = factory(Shift::class)->create();
        $shiftEarly = factory(EarlyShift::class)->create([
            'shift_id' => 1
        ]);
        $shift->earlyShift()->save($shiftEarly);

        $this->put('/admin/shift/1', [
            'name' => 'Shift T',
            'start_time' => '8:00:00',
            'end_time' => '17:00:00',
            'minimun_staff' => 5,
            'early_start_time' => '7:00:00',
            'early_end_time' => '16:00:00',
            'num_early_spot' => '2'
        ]);

        $shiftSelect = DB::select('select * from early_shifts where early_start_time = "7:00:00"');
        $this->assertEquals('7:00:00', $shiftSelect[0]->early_start_time);
    }

    /**
     * Test shift delete or destroy shift
     *
     * @param shift id
     * @return void
    **/
    public function testShiftDeleteNoDBRecord()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        $shift = factory(Shift::class)->create();
        $shiftEarly = factory(EarlyShift::class)->create([
            'shift_id' => 1
        ]);
        $shift->earlyShift()->save($shiftEarly);

        $this->delete('/admin/shift/1');
        self::assertCount(0, Shift::all());
    }

    /**
     * Test early shift delete or destroy shift
     *
     * @param shift id
     * @return void
     **/
    public function testEarlyShiftDeleteNoDBRecord()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);
        $shift = factory(Shift::class)->create();
        $shiftEarly = factory(EarlyShift::class)->create([
            'shift_id' => 1
        ]);
        $shift->earlyShift()->save($shiftEarly);

        $this->delete('/admin/shift/1');
        self::assertCount(0, EarlyShift::all());
    }
}
