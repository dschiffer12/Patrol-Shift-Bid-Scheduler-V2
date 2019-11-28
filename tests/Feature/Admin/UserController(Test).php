<?php

namespace Tests\Feature;

use App\Models\Officer;
use App\Role;
use App\User;
use App\Specialty;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Authorized users can access the Users List
     *
     * @return void
     **/
    public function testAuthUsersRootAdminAccessUsersList()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get('/admin/users');

        $response->assertOk();
    }

    /**
     * Index method return the user value
     *
     * @return void
     **/
    public function testIndexReturnValueUsers()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get('/admin/users');

        $response->assertViewIs('admin.users.index');
        $response->assertViewHas('users');
    }

    /**
     * Test method edit return a list of values
     *
     * @return void
    **/
    public function testEditReturnValueList()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        $response = $this->get(route('admin.users.edit', 1));

        //$response->assertOk();
        $response->assertViewHasAll(['user','roles','specialties']);
    }

    /**
     * Test that the method update a user with role and specialty in the database
     *
     * @return void
     **/
    public function testUpdateInDBUpdatedValuesPresent()
    {
        $this->withoutExceptionHandling();
        //Create the user with access to modify other users profile
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        factory(Role::class)->create(['name' => 'admin']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        //create the user that is going to be modify
        $userTwo = factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'jdoe@ppd.gov',
            'date_in_position' => '2015-4-3'
        ]);
        $role = factory(Role::class)->create(['name' => 'officer']);
        $specialty = factory(Specialty::class,2)->create();
        factory(Specialty::class)->create(['name' => 'PTO']);
        $userTwo->specialties()->attach($specialty);
        $userTwo->roles()->attach($role);

        $this->put('/admin/users/2',[
            'name' => 'John Cabrera',
            'email' => 'jcabrera@ppd.gov',
            'date_in_position' => '2015-3-3',
            'role' => '2',
            'specialtiess' => ['3'],
            'notes' => 'This is my first note',
            'unit_number' => 2,
            'emergency_number' => 4,
            'vehicle_number' => 5,
            'zone' => '6'
        ]);

        $userUpdated = User::where('name', 'John Cabrera')->firstOrFail();
        $this->assertEquals('John Cabrera', $userUpdated->name);

        $userUpdated = User::where('email', 'jcabrera@ppd.gov')->firstOrFail();
        $this->assertEquals('jcabrera@ppd.gov', $userUpdated->email);

        $userUpdated = User::where('date_in_position', '2015-3-3')->firstOrFail();
        $this->assertEquals('2015-3-3', $userUpdated->date_in_position);

        $this->assertEquals('admin',$userUpdated->roles[0]->name);

        $this->assertEquals('PTO',$userUpdated->specialties[0]->name);
    }

    /**
     * Test that the method update a user to cover password change
     *
     * @return void
     **/
    public function testUpdateInDBUpdatedPassword()
    {
        $this->withoutExceptionHandling();
        //Create the user with access to modify other users profile
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        factory(Role::class)->create(['name' => 'admin']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        //create the user that is going to be modify
        $userTwo = factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'jdoe@ppd.gov',
            'date_in_position' => '2015-4-3'
        ]);
        $role = factory(Role::class)->create(['name' => 'officer']);
        $specialty = factory(Specialty::class,2)->create();
        factory(Specialty::class)->create(['name' => 'PTO']);
        $userTwo->specialties()->attach($specialty);
        $userTwo->roles()->attach($role);

        $this->put('/admin/users/2',[
            'name' => 'John Cabrera',
            'email' => 'jcabrera@ppd.gov',
            'date_in_position' => '2015-3-3',
            'password' => 'password2',
            'role' => '2',
            'specialtiess' => ['3'],
            'notes' => 'This is my first note',
            'unit_number' => 2,
            'emergency_number' => 4,
            'vehicle_number' => 5,
            'zone' => '6'
        ]);

        $userUpdated = User::where('name', 'John Cabrera')->firstOrFail();
        $this->assertEquals('John Cabrera', $userUpdated->name);
    }

    /**
     * Test update method to test officer information a new officer is inserted in the database and
     * modify.
     *
     * @return void
    **/
    public function testUpdateInDBUpdatedOfficer()
    {
        $this->withoutExceptionHandling();
        //Create the user with access to modify other users profile
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        factory(Role::class)->create(['name' => 'admin']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        //create the user that is going to be modify
        $userTwo = factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'jdoe@ppd.gov',
            'date_in_position' => '2015-4-3'
        ]);
        $role = factory(Role::class)->create(['name' => 'officer']);
        $specialty = factory(Specialty::class,2)->create();
        factory(Specialty::class)->create(['name' => 'PTO']);
        $userTwo->specialties()->attach($specialty);
        $userTwo->roles()->attach($role);
        factory(Officer::class)->create(['user_id' => 2]);

        $this->put('/admin/users/2',[
            'name' => 'John Cabrera',
            'email' => 'jcabrera@ppd.gov',
            'date_in_position' => '2015-3-3',
            'role' => '2',
            'specialtiess' => ['3'],
            'notes' => 'This is my first note',
            'unit_number' => 2,
            'emergency_number' => 4,
            'vehicle_number' => 5,
            'zone' => '6'
        ]);

        $officerUpdated = Officer::where('unit_number', 2)->firstOrFail();
        $this->assertEquals(2, $officerUpdated->unit_number);

        $officerUpdated = Officer::where('emergency_number', 4)->firstOrFail();
        $this->assertEquals(4, $officerUpdated->emergency_number);

        $officerUpdated = Officer::where('vehicle_number', 5)->firstOrFail();
        $this->assertEquals(5, $officerUpdated->vehicle_number);

        $officerUpdated = Officer::where('zone', '6')->firstOrFail();
        $this->assertEquals('6', $officerUpdated->zone);
    }

    /**
     * Test destroy method user created for testing is deleted from the database, expected value DB count 1, only
     * with the user created for authorization purpose
     *
     *@return void
    **/
    public function testDestroyDBValueOne()
    {
        $this->withoutExceptionHandling();
        //Create the user with access to delete other user profiles
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root']);
        $user->roles()->attach($role);
        $this->actingAs($user);

        //create the user that is going to be modify
        $userTwo = factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'jdoe@ppd.gov',
            'date_in_position' => '2015-4-3'
        ]);
        $role = factory(Role::class)->create(['name' => 'officer']);
        $specialty = factory(Specialty::class)->create(['name' => 'PTO']);
        $userTwo->specialties()->attach($specialty);
        $userTwo->roles()->attach($role);

        $this->delete('/admin/users/2');

        $oneUserOnly = User::all();
        $this->assertCount(1, $oneUserOnly);
    }
}
