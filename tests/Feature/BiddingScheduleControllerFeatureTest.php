<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\BiddingSchedule;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BiddingScheduleControllerFeatureTest extends TestCase
{
    /**
     * Test Index Method in Bidding Schedule Controller.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = new User(array('name' => 'Admin'));
        $this->be($user); //You are now authenticated

        $response = $this->get('/');
        //$response = $this->get('/admin/bidding-schedule');

        $response->assertStatus(200);

        //$biddingScheduleActive = BiddingSchedule::where('currently_active', '1')->orderBy('start_day', 'desc')->get();

        //$response->assertViewHas('biddingschedulesactive', $biddingScheduleActive);
    }
}
