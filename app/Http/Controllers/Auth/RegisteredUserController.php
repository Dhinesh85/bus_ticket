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
      
         $assignLocation->user_id = $user->id;
         $assignLocation->is_active = 0;
         $assignLocation->save();
 
      
 
         // Process payment
         $payment = new Payment();
         $payment->payment_status = 'not_paid';
         $payment->user_id = $user->id;
         $payment->save();
       
        event(new Registered($user));

      
        Auth::login($user);

       
        return redirect(RouteServiceProvider::HOME);
    }
}
