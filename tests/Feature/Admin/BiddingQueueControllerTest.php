<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use App\Models\BiddingQueue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\BiddingSchedule as BiddingScheduleModel;

class BiddingQueueControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Assert that the Index method return a view with the following parameters schedules
     *
     * @return void
     */
    public function testIndexReturnViewParamete()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        factory(BiddingScheduleModel::class)->create();
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get('/admin/bidding-queue');

        $response->assertViewHas('schedules');
    }

    /**
     * Assert that the Show method return a view with the following parameters schedules and biddingQueue
     *
     * @return void
    **/
    public function testShowReturnValuesView()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $biddingSchedule = factory(BiddingScheduleModel::class)->create([
            'currently_active' => 1
        ]);
        $biddingQueue = factory(BiddingQueue::class)->create([
            'user_id' => $user->id,
            'bidding_schedule_id' => $biddingSchedule->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/admin/bidding-queue/1', ['schedule_id' => 1]);

        //$response->assertViewIs('admin.queue');
        $response->assertViewHasAll(['schedules', 'biddingQueue']);
    }
}
