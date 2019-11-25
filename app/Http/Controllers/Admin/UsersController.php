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
use App\Models\Officer;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(2);
 
        return view('admin.users.index')->with('users', User::paginate(5));

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
        // if(Auth::user()->id == $user->id){
        //     return redirect()->route('admin.users.index')->with('warning', 'You are not allowed to edit yourself.');
        // }

        //dd($user);
        $roles = Role::all();
        $specialties = Specialty::all();
        $officer = $user->officer;

        if(!$officer) {
            $officer = new Officer;
        }

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'specialties' => $specialties,
            'officer' => $officer
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
            'unit_number' => ['nullable', 'numeric', 'min:0'],
            'emergency_number' => ['nullable', 'numeric', 'min:0'],
            'vehicle_number' => ['nullable', 'numeric', 'min:0'],
            'zone' => ['nullable', 'string', 'max:255'],
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

        // check if user had a record in the officers table
        if($validatedData['unit_number'] || $validatedData['emergency_number'] || $validatedData['vehicle_number']) {    
            $officer = $user->officer;

            if(!$officer) {
                $officer = new Officer;
                $offcier->unit_number = $validatedData['unit_number'];
                $offcier->emergency_number = $validatedData['emergency_number'];
                $offcier->vehicle_number = $validatedData['vehicle_number'];
                $officer->zone = $validatedData['zone'];
                $officer->save();
            } else {
                $officer->update([
                    'unit_number'=> $validatedData['unit_number'],
                    'emergency_number'=> $validatedData['emergency_number'],
                    'vehicle_number'=> $validatedData['vehicle_number'],
                    'zone'=> $validatedData['zone']
                ]);
            }   
        }


        $user->roles()->sync($validatedData['role']);

        // attach all the specialties
        if($request->filled('specialtiess')) {
            $user->specialties()->sync($validatedData['specialtiess']);
        }
        
        return redirect()->route('admin.users.index')->with('success', 'User: ' . $user->name . ' successfully updated.');
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
        return redirect()->route('admin.users.index')->with('success', 'User: '. $user->name . ' successfully deleted.');
    }
}
