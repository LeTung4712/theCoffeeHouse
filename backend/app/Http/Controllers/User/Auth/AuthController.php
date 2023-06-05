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
    public function login(Request $request)
    {
        $user = User::where('mobile_no', $request->mobile_no)->first();
        if (!$user) { //nếu không có user thì tạo mới
            $user = User::create([
                'last_name' => 'Guest',
                'mobile_no' => $request->mobile_no,
                'birth' => DB::raw('CURRENT_TIMESTAMP'),
            ]);
            return response([
                'error' => false,
                'message' => 'create user successfully',
            ], 200);
        }

        $sendOtp = $this->sendSmsNotification($user);         

        if ($sendOtp) return response([ 
            'error' => false,
            'message' => 'OTP sent successfully',
            'sendOtp' => $sendOtp,
        ], 200);
        else return response([
            'error' => true,
        ], 500);
    }
    //dùng twilio để gửi mã otp
    public function sendSmsNotification($user)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");
        $client = new Client($account_sid, $auth_token);
        $receiverNumber = $user->mobile_no;
        $otp = $this->generate($user); 
        $message = 'Your OTP to login The Coffee House is: ' . $otp;

        $result = $client->messages->create($receiverNumber, [
            'from' => $twilio_number,
            'body' => $message,
        ]);
        return $result; 
    }
    //
    public function generate($user)
    {
        $verificationCode = $this->generateOtp($user);
        return $verificationCode->otp;
    }

    //tạo mã otp trong database và có hiệu lực trong 3 phút 
    public function generateOtp($user)
    {
        // kiểm tra xem có mã otp nào trong database không và lấy mã otp mới nhất
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();
        // lấy thời gian hiện tại
        $now = Carbon::now();
        // nếu có mã otp và mã otp đó vẫn còn hiệu lực thì trả về mã otp đó
        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) { //now()->isBefore : kiểm tra xem thời gian hiện tại có trước thời gian hết hạn của mã otp không
           
            return $verificationCode;
        }
        // nếu không có mã otp hoặc mã otp đó đã hết hiệu lực thì tạo mã otp mới
        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(100000, 999999),
            'expire_at' => Carbon::now()->addMinutes(3) // thời gian hết hạn = thời gian hiện tại + 3 phút
        ]);
    }
    //kiểm tra mã otp
    public function checkOtp(Request $request)
    {
        
    }
}
