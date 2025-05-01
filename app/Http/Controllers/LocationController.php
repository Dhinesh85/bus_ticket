<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{

    public function index()
    {
        $locations = Location::all();
        $roleId = Auth::user()->role_id;

        $permissions = DB::table('role_has_permissions')
            ->where('role_id', $roleId)->first();

        return view('locations.index', compact('locations', 'permissions'));
    }

    


    public function store(Request $request)
    {
        try{
        $request->validate([
            'city' => 'required|string|max:100',
            'from' => 'required|string|max:100',
            'to' => 'required|string|max:100',
            'payment' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        
        $category = new Location();
        $category->city = $request->input('city');
        $category->from = $request->input('from');
        $category->to = $request->input('to');
        $category->payment = $request->input('payment');
        $category->is_active = 0;

        $category->save();

        if($category->is_active == 1)
        {
            $category = new Location();
            $category->city = $request->input('city');
            $category->from = $request->input('to');
            $category->to = $request->input('from');
            $category->payment = $request->input('payment');
            $category->is_active = 0;
            $category->save();
        }        

        return redirect()->route('location.index')->with('success', 'Location created successfully!');
    }
        catch (\Illuminate\Database\QueryException $e) { 
          
            return redirect()->back()->with('error', 'Error occurred while creating location.');
        }
    }
}
