@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header">Xác thực OTP</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first('otp') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/verify-otp') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label>Nhập mã OTP (6 số)</label>
                                <input type="text" name="otp" class="form-control" placeholder="VD: 123456" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Xác thực
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection