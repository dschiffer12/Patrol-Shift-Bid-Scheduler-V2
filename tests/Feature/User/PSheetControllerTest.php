<?php

namespace Tests\Feature\User;

use App\Models\Officer;
use App\Role;
use App\Specialty;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PSheetControllerTest extends TestCase
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
        $specialty = factory(Specialty::class)->create();
        $user->specialties()->attach($specialty);
        $user->roles()->attach($role);

        factory(Officer::class)->create([ 'user_id' => 1 ]);

        $this->actingAs($user);


    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexReturnView()
    {
        $this->setUp();
    }
}
