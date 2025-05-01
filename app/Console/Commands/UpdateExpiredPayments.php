<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Userlocation;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class UpdateExpiredPayments extends Command
{
    protected $signature = 'payment:update-expired';
    protected $description = 'Update payment status to expired if end date has passed';

    public function handle()
    {
        $now = Carbon::now();

        // Get all active user locations whose end date has passed
        $expiredLocations = Userlocation::where('is_active', 1)
            ->whereDate('end_date', '<', $now)
            ->get();

        foreach ($expiredLocations as $location) {
            // Update user location
            $location->is_active = 0;
            $location->save();

            // Update related payment status to expired
            $payment = Payment::where('user_id', $location->user_id)
                ->where('location_id', $location->id)
                ->latest()
                ->first();

            if ($payment && $payment->payment_status !== 'not_paid') {
                $payment->payment_status = 'not_paid';
                $payment->save();

                // Send SMS to the user about the expired payment
                $this->sendExpiredPaymentSms($location->user_id);
            }
        }

        $this->info('Expired payments and user status updated successfully.');
    }

    protected function sendExpiredPaymentSms($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return;
        }

        // Twilio client
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $message = "Your payment has expired. Please renew your payment to continue.";

        try {
            $twilio->messages->create(
                $user->number, // User's phone number
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
}