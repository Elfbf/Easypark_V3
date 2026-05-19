<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::where('email', $request->email)->delete();

        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'expired_at' => Carbon::now()->addMinutes(10),
            'is_used'    => false,
        ]);

        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Kode OTP Reset Password EasyPark');
        });

        return response()->json([
            'success' => true,
            'message' => 'OTP terkirim ke email',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ]);

        $record = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->code)
            ->where('is_used', false)
            ->where('expired_at', '>', Carbon::now())
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'OTP tidak valid atau sudah kedaluwarsa',
            ], 422);
        }

        $record->update(['is_used' => true]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil diverifikasi',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:users,email',
            'password'              => 'required|min:8|confirmed',
        ]);

        $used = PasswordResetOtp::where('email', $request->email)
            ->where('is_used', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$used) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi OTP diperlukan',
            ], 422);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        PasswordResetOtp::where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset',
        ]);
    }
}
