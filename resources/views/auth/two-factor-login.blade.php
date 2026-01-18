@extends('layouts.auth')

@section('title', 'Two-Factor Verification')

@section('content')
<div>
    <div class="mb-4 text-sm text-gray-600">
        A verification code has been sent to your email. Please enter the 6-digit code below to complete your login.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
            {{ session('status') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="font-medium text-sm text-red-600">{{ $errors->first() }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login.verify') }}">
        @csrf

        <!-- OTP Code -->
        <div>
            <label for="otp" class="block font-medium text-sm text-gray-700">Verification Code</label>
            <input id="otp" type="text" name="otp" maxlength="6" required autofocus autocomplete="one-time-code" 
                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-center text-2xl font-mono tracking-widest"
                   placeholder="000000">
            <p class="mt-2 text-xs text-gray-500">Code expires in 10 minutes</p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                Back to login
            </a>

            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Verify & Login
            </button>
        </div>

        <!-- Resend OTP -->
        <div class="mt-6 text-center">
            <span class="text-sm text-gray-600">Didn't receive the code?</span>
            <button type="submit" formaction="{{ route('two-factor.resend') }}" class="text-sm text-indigo-600 hover:text-indigo-800 underline font-medium ml-1">
                Resend Code
            </button>
        </div>
    </form>
</div>
@endsection
