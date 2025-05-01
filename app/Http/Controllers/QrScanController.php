<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Userlocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QrScanController extends Controller
{
    public function index()
    {
        $locations = Userlocation::where('is_active', 1)->with('user')
            ->get();
        $roleId = Auth::user()->role_id;

        $permissions = DB::table('role_has_permissions')
            ->where('role_id', $roleId)->first();

        return view('qrcode.index', compact('locations', 'permissions'));
    }
}
