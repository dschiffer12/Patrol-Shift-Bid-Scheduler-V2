<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatchAllController extends Controller
{
    
    public function handle() {    
        return redirect('/')->with('warning', 'Route not available.');
    }
}
