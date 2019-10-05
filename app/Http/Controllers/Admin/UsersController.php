<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\Specialty;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        
        // get all roles expet root.
        $roles = Role::where('name', '!=', 'root')->get();
        $specialties = Specialty::all();
        //return view('admin.users.index')->with('users', $users);

        return view('admin.users.index')->with([
            'users' => $users,
            'roles' => $roles, 
            'specialties' => $specialties
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //this is not the place for admins to edit there own information
        if(Auth::user()->id == $user->id){
            return redirect()->route('admin.users.index');
        }

        //dd($user);
        $roles = Role::all();
        $specialties = Specialty::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'specialties' => $specialties
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $user = User::findOrFail($id);
        
        /**
         * Validate the form data
         */

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required'],
            'date_in_position' => ['required', 'before:tomorrow'],
            'notes' => ['max:255'],
            'specialtiess' => ['array'],
            'specialtiess.*' => ['max:255'],
            'notes' => ['max:255'],
        ]);

        if($request->email != $user->email){
            $request->validate([
                'email' => ['unique:users'],
            ]);
        }

        /**
         * Validate password if it's being changed
         */
        if($request->filled('password')) {
            $validatedData = array_merge($validatedData, $request->validate([
                'password' => ['string', 'min:8'],
            ]));
            
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'date_in_position' => $validatedData['date_in_position'],
                    'notes' => $validatedData['notes'],
                    'date_in_position' => $validatedData['date_in_position'],
                    'notes' => $validatedData['notes'],
                    'password' => Hash::make($validatedData['password']),
                ]);
        } else {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'date_in_position' => $validatedData['date_in_position'],
                    'notes' => $validatedData['notes'],
                    'date_in_position' => $validatedData['date_in_position'],
                    'notes' => $validatedData['notes'],
                ]);
        }
      
        $user->roles()->sync($validatedData['role']);

        // attach all the specialties
        if($request->filled('specialtiess')) {
            $user->specialties()->sync($validatedData['specialtiess']);
        }
        
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // detach the user from the roles relationship table, can also be done using "on delete cascade"
        $user->roles()->detach();

        // detach the user from the specialties relationship table, can also be done using "on delete cascade"
        $user->specialties()->detach();

        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
