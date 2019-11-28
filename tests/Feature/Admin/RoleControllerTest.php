<?php

namespace Tests\Feature\Admin;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleControllerTest extends TestCase
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
        $user->roles()->attach($role);
        $this->actingAs($user);
    }

    /**
     * Test Index method to return a View with some parameter and the inside some expected data.
     *
     * @return void
    **/
    public function testIndexReturnViewParamValue()
    {
        $this->setUp();

        $response = $this->get('/admin/roles');

        $data = $response->getOriginalContent()->getData()['roles'];
        $roleName = $data[0]->name;

        $response->assertViewIs('admin.roles.index');
        $response->assertViewHas('roles');
        $this->assertEquals('admin', $roleName);
    }

    /**
     * Test Add method that a Role save in the database
     *
     * @return void
    **/
    public function testAddRoleSaveInDB()
    {
        $this->setUp();

        $this->post('/admin/roles/add', ['name' => 'officer']);

        $savedRole = Role::where('name', 'officer')->get();

        $this->assertCount(1, $savedRole);
    }

    /**
     * Test Delete method that a created Role is not in the database any longer.
     *
     * @return void
    **/
    public function testDeleteRoleDaleteFromDB()
    {
        $this->setUp();

        factory(Role::class)->create(['name' => 'officer']);

        $this->get('/admin/roles/3/delete');

        $deletedRole = Role::where('name', 'officer')->get();

        $this->assertCount(0, $deletedRole);
    }

    /**
     * Test Delete method Role is assigned to another User.
     *
     * @return void
     **/
    public function testDeleteRoleNotDeletedAssigToUser()
    {
        $this->setUp();

        //factory(Role::class)->create(['name' => 'officer']);

        $response = $this->get('/admin/roles/1/delete');

        $response->assertRedirect('/admin/roles/');
    }
}
