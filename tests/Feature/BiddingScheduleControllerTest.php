<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BiddingScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Make sure that no authenticated users have access to see Bidding Schedule page.
     *
     * @return void
     */
    public function testLoggedUsersCanSeeSchedules()
    {
        $response = $this->get('/admin/bidding-schedule/index');

        $response->assertRedirect('/login');
    }

    /**
     * Only root or admin users can access Bidding Schedule page.
     *
     * @return void
    **/
    public function testAuthUsersRootAdminAccessSchedule()
    {
        $this->actingAs(factory(User::class)->create(['name' => 'admin']));

        $response = $this->get('/admin/bidding-schedule/index');

        $response->assertOk();
    }
}
