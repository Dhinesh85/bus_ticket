<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Payment;
use App\Models\User;
use App\Models\Userlocation;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
      
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'aadhaar' => ['nullable', 'regex:/^\d{4}\s\d{4}\s\d{4}$/'], 
        ]);

      
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, 
            'aadhaar' => $request->aadhaar, 
        ]);

        
         // Save location assignment
         $assignLocation = new Userlocation();
         $assignLocation->city = null;
         $assignLocation->from = null;
         $assignLocation->to = null;
         $assignLocation->payment = null;
         $assignLocation->start_date =null;
         $assignLocation->end_date =null;
         $assignLocation->user_id = null;
         $assignLocation->is_active = 0;
         $assignLocation->save();
 
      
 
         // Process payment
         $payment = new Payment();
         $payment->payment_method = null;
         $payment->payment_status = 'not_paid';
         $payment->payment_amount = null;
         $payment->payment_date = null;
         $payment->user_id = null;
         $payment->location_id = null;
 
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
       
        event(new Registered($user));

      
        Auth::login($user);

       
        return redirect(RouteServiceProvider::HOME);
    }
}
