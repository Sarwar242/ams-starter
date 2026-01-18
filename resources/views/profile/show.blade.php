@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="space-y-6">
    <!-- Profile Information -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
            <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>

            <!-- Session Status -->
            @if (session('status') === 'profile-information-updated')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    Profile updated successfully.
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->updateProfileInformation->any())
                <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="font-medium text-sm text-red-600">Whoops! Something went wrong.</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->updateProfileInformation->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user-profile-information.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
                </div>

                <!-- Employee Code -->
                <div>
                    <label for="employee_code" class="block text-sm font-medium text-gray-700">Employee Code</label>
                    <input id="employee_code" type="text" name="employee_code" value="{{ old('employee_code', Auth::user()->employee_code) }}" autocomplete="off" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
                </div>

                <!-- Display Only Fields -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ Auth::user()->role === 'leader' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ Auth::user()->role === 'user' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ Auth::user()->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if (Auth::user()->joined_at)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Joined Date</label>
                    <div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-700">
                        {{ Auth::user()->joined_at->format('F j, Y') }}
                    </div>
                </div>
                @endif

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900">Update Password</h3>
            <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>

            <!-- Session Status -->
            @if (session('status') === 'password-updated')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    Password updated successfully.
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->updatePassword->any())
                <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="font-medium text-sm text-red-600">Whoops! Something went wrong.</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user-password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Two Factor Authentication (Email OTP) -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900">Two Factor Authentication (Email OTP)</h3>
            <p class="mt-1 text-sm text-gray-600">Add additional security to your account. When enabled, you'll receive a verification code via email during login.</p>

            <!-- Session Status -->
            @if (session('status') === 'two-factor-enabled')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    ✓ Two factor authentication has been enabled successfully!
                </div>
            @endif

            @if (session('status') === 'two-factor-disabled')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    Two factor authentication has been disabled.
                </div>
            @endif

            @if (session('status') === 'otp-sent')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    ✓ Verification code sent to your email! Please check your inbox.
                </div>
            @endif

            @if (session('status') === 'otp-verified')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    ✓ OTP verified successfully!
                </div>
            @endif

            @if ($errors->has('otp'))
                <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="font-medium text-sm text-red-600">{{ $errors->first('otp') }}</div>
                </div>
            @endif

            <div class="mt-6">
                @if (Auth::user()->two_factor_enabled)
                    <!-- 2FA is enabled -->
                    <div class="space-y-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-sm text-green-700 font-medium">
                                ✓ Email-based two-factor authentication is <strong>enabled</strong>.
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                When you log in, you'll receive a 6-digit verification code at <strong>{{ Auth::user()->email }}</strong>
                            </p>
                        </div>

                        <!-- Test OTP -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">🧪 Test Your 2FA</h4>
                            <p class="text-sm text-gray-700 mb-3">Click below to send a test verification code to your email.</p>
                            
                            <form method="POST" action="{{ route('two-factor.send-otp') }}" class="space-y-4">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    📧 Send Test Code
                                </button>
                            </form>

                            <!-- Verify Test OTP -->
                            @if (session('status') === 'otp-sent')
                                <form method="POST" action="{{ route('two-factor.verify') }}" class="mt-4 space-y-3">
                                    @csrf
                                    <div>
                                        <label for="otp" class="block text-sm font-medium text-gray-700">Enter the 6-digit code from your email:</label>
                                        <input id="otp" type="text" name="otp" maxlength="6" placeholder="000000" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-center text-lg font-mono">
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        ✓ Verify Code
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Disable 2FA -->
                        <form method="POST" action="{{ route('two-factor.disable') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                🔓 Disable 2FA
                            </button>
                        </form>
                    </div>
                @else
                    <!-- 2FA is disabled -->
                    <div class="space-y-4">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">🔒 How Email 2FA Works</h4>
                            <ul class="text-sm text-gray-700 space-y-2 list-disc list-inside">
                                <li>When you log in, we'll send a 6-digit code to your email</li>
                                <li>Enter the code to complete your login</li>
                                <li>Codes expire after 10 minutes</li>
                                <li>Each code can only be used once</li>
                            </ul>
                        </div>
                        
                        <form method="POST" action="{{ route('two-factor.enable') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                🔐 Enable Two-Factor Authentication
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
