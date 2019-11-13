<?php

namespace Tests\Feature\User;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileControllerTest extends TestCase
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
     * A Assert that the Index method return a view .
     *
     * @return void
     */
    public function testIndexReturnView()
    {
        $this->setUp();

        $response = $this->get('/user/profile');

        $response->assertViewIs('user.profile.index');
        $response->assertStatus(200);
    }

    /**
     * A Assert that the Index method return a view with the following parameter schedules.
     *
     * @return void
     */
    public function testIndexReturnViewValue()
    {
        $this->setUp();

        $response = $this->get('/user/profile');

        $response->assertViewHas('user');
    }

    /**
     * Edit method return a view
     *
     * @return void
    **/
    public function testEditReturnView()
    {
        $this->setUp();

        $response = $this->get(route('user.profile.edit', 1));

        $response->assertViewIs('user.profile.edit');
    }

    /**
     * Edit method return a view with a value.
     *
     * @return void
     **/
    public function testEditReturnViewValue()
    {
        $this->setUp();

        $response = $this->get(route('user.profile.edit', 1));

        $response->assertViewHas('user');
    }

    /**
     * Assert that user profile gets updated with the new value. Assert the method return a view
     *
     * @return void
     **/
    public function testUpdateUserWithValue()
    {
        $this->setUp();

        $response = $this->put(route('user.profile.update', 1), [
            'name' => 'John Doe',
            'email' => 'jdoe@test.com',
            'password' => 'password2'
        ]);

        $updatedUser = User::where('name', 'John Doe')->first();

        $this->assertEquals('John Doe', $updatedUser->name);
        $this->assertEquals('jdoe@test.com', $updatedUser->email);
        $response->assertRedirect(route('user.profile.index'));
    }
}
