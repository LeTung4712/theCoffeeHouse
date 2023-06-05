<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\VerificationCode;
use Twilio\Rest\Client;
use carbon\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        $rêciverNumber = '+84828035636';
        $message = 'Hello';
        try {
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
            $client = new Client($account_sid, $auth_token);
            $result = $client->messages->create($rêciverNumber, [
                'from' => $twilio_number,
                'body' => $message
            ]);
            return response([
                'error' => false,
                'message' => 'OTP sent successfully',
                'sendOtp' => $result,
                'account_sid' => $account_sid,
                'auth_token' => $auth_token,
                'twilio_number' => $twilio_number,
                'rêciverNumber' => $rêciverNumber,
                'result' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
}
