<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();

        return view('admin.roles.index')->with('roles', $roles);
    }


    public function add(Request $request) {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role = new Role;
        $role->name = $validatedData['name'];
        $role->save();

        return redirect('/admin/roles/')->with('success', 'Role added!!');
    }


    public function delete($id) {

        $role = Role::find($id);
        $users = $role->users;

        
        if($users->first()) {
            return redirect('/admin/roles/')->with('warning', 'Can not delete role '. $role->name . ' because it\'s been assigned to at least one User.');
        } else {
            Role::destroy($id);
            
            return redirect('/admin/roles/')->with('success', 'Role deleted');
        }

    }
}
