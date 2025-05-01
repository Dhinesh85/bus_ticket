<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class RazorpayController extends Controller
{
    /**
     * Verify Razorpay payment
     */
    public function verify(Request $request)
    {
        $input = $request->all();
        
        $razorpay_payment_id = $input['razorpay_payment_id'];
        $razorpay_order_id = $input['razorpay_order_id'] ?? null;
        $razorpay_signature = $input['razorpay_signature'] ?? null;
        
        // You should validate the signature here
        // For production, use Razorpay's SDK to verify signature
        
        // For now, we'll just update our payment record
        $payment = Payment::where('razorpay_payment_id', $razorpay_payment_id)->first();
        
        if ($payment) {
            $payment->payment_status = 'paid';
            $payment->save();
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Payment not found'], 404);
    }
    
    /**
     * Handle Razorpay webhook
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Razorpay Webhook', $payload);
        
        // Verify webhook signature
        // $webhookSignature = $request->header('X-Razorpay-Signature');
        
        // Handle different event types
        if (isset($payload['event']) && $payload['event'] === 'payment.authorized') {
            $paymentId = $payload['payload']['payment']['entity']['id'];
            $payment = Payment::where('razorpay_payment_id', $paymentId)->first();
            
            if ($payment) {
                $payment->payment_status = 'paid';
                $payment->save();
            }
        }
        
        return response()->json(['status' => 'received']);
    }
}