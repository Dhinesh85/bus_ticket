<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Location;
use App\Models\payment;
use App\Models\Userlocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role; // KEY : MULTIPERMISSION
use Spatie\Permission\Models\Permission; // KEY : MULTIPERMISSION
use Twilio\Rest\Client;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $roleId = $user->role_id;
    
            $permissions = DB::table('role_has_permissions')
            ->where('role_id', $roleId)
            ->first();

           
            // Fetch active and deactive users based on payment status
            // Active Users: payment_status = 'paid'
            $activeUsers = DB::table('users')
                ->join('payments', 'users.id', '=', 'payments.user_id')
                ->where('payments.payment_status', 'paid')
                ->select('users.*')
                ->distinct()
                ->get();
          
            // Deactive Users: payment_status = 'not_paid'
            $deactiveUsers = DB::table('users')
                ->join('payments', 'users.id', '=', 'payments.user_id')
                ->where('payments.payment_status', 'not_paid')
                ->select('users.*')
                ->distinct()
                ->get();

            // Role permissions
           
    
            if ($roleId == 3) {
                $userDetails = DB::table('users')
                    ->leftJoin('payments', 'users.id', '=', 'payments.user_id')
                    ->leftJoin('userlocations', 'users.id', '=', 'userlocations.user_id')
                    ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                    ->where('users.id', $user->id)
                    ->select('users.*', 'payments.*', 'userlocations.*', 'roles.name as role_name')
                    ->first();
    
                return view('users.index', compact('userDetails', 'activeUsers', 'deactiveUsers', 'permissions'));
            }
    
            return view('users.index', compact('user', 'activeUsers', 'deactiveUsers', 'permissions'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $cities = Location::all()->groupBy('city');
        return view('users.create', compact('roles', 'cities'));
    }



   
    public function getFormsByCity(Request $request)
    {
        $city = $request->get('city');
        $forms = Location::where('city', $city)->get(['id', 'from']);
        return response()->json($forms);
    }

   
    public function getToCountriesByForm(Request $request)
    {
        $formId = $request->get('form_id');
        $location = Location::find($formId);

        return response()->json([
            'to_id' => $location?->id,
            'to_name' => $location?->to,
        ]);
    }

    
    public function getPaymentByTo(Request $request)
    {
        $toId = $request->get('to_id');
        $location = Location::find($toId);

        return response()->json([
            'payment' => $location?->payment,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('profile_images', $imageName, 'public');
            }
    
            // Create user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->number = $request->number;
            $user->address = $request->address;
            $user->profile_image = $imagePath;
            $user->role_id = $request->role_id ?? 3; // Default to regular user if role not provided
            $user->save();
            
            // Get location information
            $From = Location::where('id', $request->from)->pluck('from')->first();
            $To = Location::where('id', $request->to_)->pluck('to')->first();
    
            // Save location assignment
            $assignLocation = new Userlocation();
            $assignLocation->city = $request->city;
            $assignLocation->from = $From;
            $assignLocation->to = $To;
            $assignLocation->payment = $request->payment;
            $assignLocation->start_date = $request->start_date;
            $assignLocation->end_date = $request->end_date;
            $assignLocation->user_id = $user->id;
            $assignLocation->is_active = ($request->payment_status === 'paid') ? 1 : 0;
            $assignLocation->save();
   
            // Send SMS to the user about their location
            $this->sendLocationSms($user->number, $assignLocation->start_date, $assignLocation->end_date);
    
            // Process payment
            $payment = new Payment();
            $payment->payment_method = $request->payment_method;
            $payment->payment_status = $request->payment_status;
            $payment->payment_amount = $request->payment;
            $payment->payment_date = $request->payment_date;
            $payment->user_id = $user->id;
            $payment->location_id = $assignLocation->id;
    
            // Handle Razorpay payment if chosen
            if ($request->payment_method === 'online' && $request->payment_status === 'paid') {
                // Verify if we have a Razorpay payment ID
                if (!$request->razorpay_payment_id) {
                    throw new \Exception('Online payment was selected but no Razorpay payment ID was provided.');
                }
    
                $payment->razorpay_payment_id = $request->razorpay_payment_id;
                $payment->razorpay_order_id = $request->razorpay_order_id;
            }
    
            $payment->save();
    
          
    
            return redirect()->route('users.index')->withSuccess('User created and payment processed successfully!');
        } catch (\Exception $e) {
            
            return redirect()->back()->withError('Error: ' . $e->getMessage());
        }
    }
    
    protected function sendLocationSms($userPhoneNumber, $startDate, $endDate)
    {
        // Twilio client
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    
        $message = "Your location has been assigned from " . $startDate->format('Y-m-d') . " to " . $endDate->format('Y-m-d') . ".";
        
        try {
            $twilio->messages->create(
                $userPhoneNumber, // User's phone number
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            // Log error or handle failure to send SMS
            Log::error('Twilio SMS failed: ' . $e->getMessage());
        }
    }
    
    
    
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $cities = Location::all()->groupBy('city');
        return view('users.edit', compact('user', 'roles','cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $roleIds = Role::whereIn('name', $request->roles)->pluck('id')->toArray();
            $user->roles()->detach(); // remove older roles assigned to user   
            $user->assignRole($roleIds); // new roles assigned to user 
            \Log::info(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Success updating data : " . json_encode([request()->all(), $user]));
            return redirect()->route('users.index')
                ->withSuccess('Updated Successfully...!');
        } catch (\Illuminate\Database\QueryException $e) { // Handle query exception
            \Log::error(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Error Query updating data : " . $e->getMessage());
            // You can also return a response to the user
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "error occurs failed to proceed...! " . $e->getMessage());
        } catch (\Exception $e) { // Handle any runtime exception
            \Log::error(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Error updating data : " . $e->getMessage() . '');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "error occurs failed to proceed...! " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->roles()->detach();
            $user->delete();
            \Log::info(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Success deleting data : " . json_encode([request()->all(), $user]));
            return redirect()->route('users.index')
                ->withSuccess('Deleted Successfully.');
        } catch (\Illuminate\Database\QueryException $e) { // Handle query exception
            \Log::error(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Error Query deleting data : " . $e->getMessage() . '');
            // You can also return a response to the user
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "error occurs failed to proceed...! " . $e->getMessage());
        } catch (\Exception $e) { // Handle any runtime exception
            \Log::error(" file '" . __CLASS__ . "' , function '" . __FUNCTION__ . "' , Message : Error deleting data : " . $e->getMessage() . '');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "error occurs failed to proceed...! " . $e->getMessage());
        }
    }
}
