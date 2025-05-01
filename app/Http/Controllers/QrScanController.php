<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QrScanController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $roleId = Auth::user()->role_id;

        $permissions = DB::table('role_has_permissions')
            ->where('role_id', $roleId)->first();

        return view('qrcode.index', compact('locations', 'permissions'));
    }
}
