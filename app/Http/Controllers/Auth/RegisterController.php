<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOTPNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RegisterController extends Controller
{
    // Thời gian chờ resend (giây)
    private const OTP_RESEND_SECONDS = 10;

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

        $this->sendOtp($user);

        return redirect()->route('otp.view')
            ->with('message', 'Mã OTP đã được gửi về email của bạn.');

    }

    // ===== FORM NHẬP OTP =====
    public function showVerifyOtpForm()
    {
        if (!session('register_email')) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp', [
            'resendSeconds' => self::OTP_RESEND_SECONDS
        ]);
    }

    // ===== VERIFY OTP =====
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (now()->greaterThan(session('register_otp_expires_at'))) {
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn.']);
        }

        if ($request->otp != session('register_otp')) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
        }

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
            'register_otp_sent_at',
        ]);

        return redirect('/home')->with('success', 'Xác thực thành công 🎉');
    }

    // ===== RESEND OTP (CHỐNG SPAM) =====
    public function resendOtp()
    {
        if (!session('register_email') || !session('register_otp_sent_at')) {
            return redirect()->route('register');
        }

        $lastSent = \Carbon\Carbon::parse(session('register_otp_sent_at'));
        $diff = now()->diffInSeconds($lastSent);

        if ($diff < self::OTP_RESEND_SECONDS) {
            $remain = self::OTP_RESEND_SECONDS - $diff;
            return back()->withErrors(['otp' => "Vui lòng chờ {$remain} giây trước khi gửi lại OTP."]);
        }

        $user = \App\Models\User::where('email', session('register_email'))->first();
        if (!$user)
            return redirect()->route('register');

        $this->sendOtp($user);

        return back()->with('message', 'Đã gửi lại mã OTP mới.');
    }
    // ===== HÀM GỬI OTP (DÙNG CHUNG) =====
    private function sendOtp(User $user)
    {
        $otp = rand(100000, 999999);

        session([
            'register_otp' => $otp,
            'register_email' => $user->email,
            'register_otp_expires_at' => now()->addMinutes(5),
            'register_otp_sent_at' => now(),
        ]);

        $user->notify(new SendOTPNotification($otp));
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
