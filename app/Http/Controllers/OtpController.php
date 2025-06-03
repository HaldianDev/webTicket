<?php

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{
    public function showForm(User $user)
    {
        return view('auth.verify-otp', ['user' => $user]);
    }

    public function verify(Request $request, User $user)
    {
        $request->validate(['otp' => 'required']);

        $otpRecord = Otp::where('user_id', $user->id)
                        ->where('otp', $request->otp)
                        ->where('expires_at', '>', now())
                        ->latest()
                        ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau telah kedaluwarsa']);
        }

        Auth::login($user); // Login setelah OTP valid

        return redirect()->route('dashboard');
    }
}
