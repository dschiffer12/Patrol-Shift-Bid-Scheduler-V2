<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Specialty;

class SpecialtyController extends Controller
{
    /**
     * to view all specialties
     */
    public function index() {
        $specialties = Specialty::all();
        return view('admin.specialties.index')->with('specialties', $specialties);
    }

    /**
     * to ass a specialty
     */
    public function add(Request $request) {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $specialty = new Specialty;
        $specialty->name = $validatedData['name'];
        $specialty->save();

        return redirect('/admin/specialties/')->with('success', 'Specialty added!!');
    }

    /**
     * to delete a specialty
     */
    public function delete($id) {

        $specialty = Specialty::find($id);
        $users = $specialty->users;

        if($users->first()) {
            return redirect('/admin/specialties/')->with('warning', 'Can not delete specialty '. $specialty->name . ' because it\'s been assigned to at least one User.');
        } else {
            Specialty::destroy($id);
            
            return redirect('/admin/specialties/')->with('success', 'Specialty deleted');
        }
    }

}
