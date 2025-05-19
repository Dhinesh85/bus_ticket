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
            ->where('role_id', $roleId)
            ->first();

        return view('locations.index', compact('locations', 'permissions'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string|max:100',
                'from' => 'required|string|max:100',
                'to' => 'required|string|max:100',
                'payment' => 'required|numeric|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            $location = new Location();
            $location->city = $request->input('city');
            $location->from = $request->input('from');
            $location->to = $request->input('to');
            $location->payment = $request->input('payment');
            $location->is_active = $request->has('is_active') ? 1 : 0;
            $location->save();

            // Create reverse trip if return ticket is selected
            if ($location->is_active == 1) {
                $reverseLocation = new Location();
                $reverseLocation->city = $request->input('city');
                $reverseLocation->from = $request->input('to');
                $reverseLocation->to = $request->input('from');
                $reverseLocation->payment = $request->input('payment');
                $reverseLocation->is_active = 1;
                $reverseLocation->save();
            }

            return redirect()->route('location.index')->with('success', 'Location created successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Error occurred while creating location.');
        }
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'city' => 'required|string|max:100',
                'from' => 'required|string|max:100',
                'to' => 'required|string|max:100',
                'payment' => 'required|numeric|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            $location = Location::findOrFail($id);
            $location->city = $request->input('city');
            $location->from = $request->input('from');
            $location->to = $request->input('to');
            $location->payment = $request->input('payment');
            $location->is_active = $request->has('is_active') ? 1 : 0;
            $location->save();

            return redirect()->route('location.index')->with('success', 'Location updated successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Error occurred while updating location.');
        }
    }

    public function show($id)
    {
        $location = Location::findOrFail($id);
        return view('locations.show', compact('location'));
    }


    public function destroy($id)
    {
        try {
            $location = Location::findOrFail($id);
            $location->delete();

            return redirect()->route('location.index')->with('success', 'Location deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Error occurred while deleting location.');
        }
    }
}
