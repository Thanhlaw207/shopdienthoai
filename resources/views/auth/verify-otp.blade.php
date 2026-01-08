@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm mt-5">
                    <div class="card-header text-center fw-bold fs-5">
                        🔐 Xác thực OTP
                    </div>

                    <div class="card-body">

                        {{-- Success --}}
                        @if (session('message'))
                            <div class="alert alert-success text-center">
                                {{ session('message') }}
                            </div>
                        @endif

                        {{-- Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger text-center">
                                {{ $errors->first('otp') }}
                            </div>
                        @endif

                        {{-- VERIFY FORM --}}
                        <form method="POST" action="{{ route('otp.verify') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-center w-100">
                                    Nhập mã OTP (6 số)
                                </label>
                                <input type="text" name="otp" class="form-control text-center fs-3 letter-spacing"
                                    maxlength="6" placeholder="123456" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                ✅ Xác thực
                            </button>
                        </form>

                        <hr>

                        {{-- RESEND OTP --}}
                        <div class="text-center">
                            <form method="POST" action="{{ route('otp.resend') }}">
                                @csrf
                                <button id="resendBtn" type="submit" class="btn btn-outline-secondary btn-sm" disabled>
                                    Gửi lại OTP (<span id="countdown">{{ $resendSeconds }}</span>s)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- COUNTDOWN --}}
    <script>
        let seconds = {{ $resendSeconds }};
        const btn = document.getElementById('resendBtn');
        const countdown = document.getElementById('countdown');

        const timer = setInterval(() => {
            seconds--;
            countdown.innerText = seconds;

            if (seconds <= 0) {
                clearInterval(timer);
                btn.disabled = false;
                btn.innerText = 'Gửi lại OTP';
            }
        }, 1000);
    </script>

    <style>
        .letter-spacing {
            letter-spacing: 6px;
        }
    </style>
@endsection