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

    <!-- Two Factor Authentication -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900">Two Factor Authentication</h3>
            <p class="mt-1 text-sm text-gray-600">Add additional security to your account using two factor authentication.</p>

            <!-- Session Status -->
            @if (session('status') === 'two-factor-authentication-enabled')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    Two factor authentication has been enabled.
                </div>
            @endif

            @if (session('status') === 'two-factor-authentication-disabled')
                <div class="mt-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                    Two factor authentication has been disabled.
                </div>
            @endif

            <div class="mt-6">
                @if (Auth::user()->two_factor_secret)
                    <!-- 2FA is enabled -->
                    <div class="space-y-4">
                        <p class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-4">
                            ✓ Two factor authentication is enabled.
                        </p>

                        @if (session('status') === 'two-factor-authentication-enabled')
                            <!-- Show QR Code -->
                            <div class="bg-white border-2 border-gray-200 rounded-lg p-4">
                                <p class="text-sm text-gray-700 mb-3">Scan the following QR code using your phone's authenticator application:</p>
                                <div class="flex justify-center p-4 bg-white">
                                    {!! Auth::user()->twoFactorQrCodeSvg() !!}
                                </div>
                            </div>

                            <!-- Recovery Codes -->
                            @if (session('recoveryCodes'))
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Recovery Codes</h4>
                                    <p class="text-sm text-gray-700 mb-3">Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.</p>
                                    <div class="bg-white border border-gray-300 rounded p-3 font-mono text-sm">
                                        @foreach (session('recoveryCodes') as $code)
                                            <div>{{ $code }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="flex gap-3">
                            <!-- Regenerate Recovery Codes -->
                            <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Regenerate Recovery Codes
                                </button>
                            </form>

                            <!-- Disable 2FA -->
                            <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Disable
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- 2FA is disabled -->
                    <div class="space-y-4">
                        <p class="text-sm text-gray-700">When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's authenticator application.</p>
                        
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Enable
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
