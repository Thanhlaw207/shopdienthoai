<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOTPNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    // ===== FORM REGISTER =====
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ===== HANDLE REGISTER =====
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Tạo user (chưa xác thực email)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Sinh OTP
        $otp = rand(100000, 999999);

        // Lưu session OTP
        session([
            'register_otp' => $otp,
            'register_email' => $user->email,
            'register_otp_expires_at' => now()->addMinutes(5),
        ]);

        // Gửi OTP
        $user->notify(new SendOTPNotification($otp));

        return redirect()->route('otp.view')
            ->with('message', 'Mã OTP đã được gửi về email của bạn.');
    }

    // ===== FORM NHẬP OTP =====
    public function showVerifyOtpForm()
    {
        if (!session('register_email')) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp');
    }

    // ===== VERIFY OTP =====
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        // Hết hạn
        if (now()->greaterThan(session('register_otp_expires_at'))) {
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn.']);
        }

        // Sai OTP
        if ($request->otp != session('register_otp')) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
        }

        // Đúng OTP
        $user = User::where('email', session('register_email'))->first();

        if (!$user) {
            return redirect()->route('register');
        }

        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        session()->forget([
            'register_otp',
            'register_email',
            'register_otp_expires_at',
        ]);

        return redirect('/home')->with('success', 'Xác thực thành công 🎉');
    }

    // ===== VALIDATOR =====
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
    }
}
