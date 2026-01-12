@extends('layout.guest')

@section('title', 'Reset Password')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="single-form">
    <div class="center-form">
        {{-- Form Header --}}
        <div class="form-header">
            <img src="{{ asset('icon/logo.png') }}" class="logo" alt="Logo">
            <h2>Reset Password</h2>
            <p>Masukkan OTP dan password baru Anda</p>
        </div>

        {{-- Form Reset Password --}}
        <form method="POST" action="{{ route('otp.reset') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? '' }}">

            {{-- OTP Input --}}
            <div class="input-group">
                <label for="otp">Kode OTP</label>
                <input 
                    type="text" 
                    id="otp" 
                    name="otp" 
                    placeholder="Masukkan kode OTP 6 digit" 
                    maxlength="6"
                    required
                    autofocus
                >
                @error('otp')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Input --}}
            <div class="input-group">
                <label for="password">Password Baru</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Minimal 6 karakter" 
                    required
                >
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Confirm Password Input --}}
            <div class="input-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Ulangi password baru" 
                    required
                >
                @error('password_confirmation')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="login-button">
                Reset Password
            </button>
        </form>

        {{-- Resend OTP Form --}}
        <form method="POST" action="{{ route('otp.send') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? '' }}">
            <button type="submit" id="resendBtn" class="resend-btn" disabled>
                Kirim ulang OTP (<span id="timer">60</span>)
            </button>
        </form>

        {{-- Link Back to Login --}}
        <div class="auth-link">
            Sudah ingat password? <a href="{{ route('login') }}">Login di sini</a>
        </div>

        {{-- Footer --}}
        <div class="footer-text">
            <p>© 2025 Library Medical Faculty</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/alert.js') }}"></script>
<script src="{{ asset('js/otp-timer.js') }}"></script>


@endpush
