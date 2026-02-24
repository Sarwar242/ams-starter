@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Welcome back, ' . Auth::user()->name)

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <x-card class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="text-indigo-100">Here's what's happening with your account today.</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </x-card>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- User Role Card -->
        <x-stat-card 
            title="Your Role" 
            :value="ucfirst(Auth::user()->role)"
            color="purple">
            @slot('icon')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            @endslot
        </x-stat-card>

        <!-- Account Status Card -->
        <x-stat-card 
            title="Account Status" 
            :value="Auth::user()->is_active ? 'Active' : 'Inactive'"
            :color="Auth::user()->is_active ? 'green' : 'red'">
            @slot('icon')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endslot
        </x-stat-card>

        <!-- Employee Code Card -->
        <x-stat-card 
            title="Employee Code" 
            :value="Auth::user()->employee_code ?? 'Not Set'"
            color="blue">
            @slot('icon')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                </svg>
            @endslot
        </x-stat-card>

        <!-- 2FA Status Card -->
        <x-stat-card 
            title="Two-Factor Auth" 
            :value="Auth::user()->usesEmailOtp() ? 'Email OTP' : (Auth::user()->usesAuthenticator() ? 'Authenticator' : 'Disabled')"
            :color="(Auth::user()->usesEmailOtp() || Auth::user()->usesAuthenticator()) ? 'green' : 'yellow'">
            @slot('icon')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            @endslot
        </x-stat-card>
    </div>

    <!-- Account Details -->
    <x-card>
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
                <a href="{{ route('profile.show') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    View Full Profile →
                </a>
            </div>
            
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</dd>
                </div>

                @if (Auth::user()->joined_at)
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->joined_at->format('F j, Y') }}</dd>
                </div>
                @endif

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->created_at->format('F j, Y') }}</dd>
                </div>

                @if (Auth::user()->email_verified_at)
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ Auth::user()->email_verified_at->format('F j, Y') }}
                    </dd>
                </div>
                @endif
            </dl>

            <div class="mt-6 flex flex-wrap gap-3">
                <x-button href="{{ route('profile.show') }}" variant="primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Edit Profile
                </x-button>
                
                @if (!Auth::user()->usesEmailOtp() && !Auth::user()->usesAuthenticator())
                <x-button href="{{ route('profile.show') }}#two-factor" variant="success">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Enable Two-Factor Auth
                </x-button>
                @endif
            </div>
        </div>
    </x-card>

    <!-- Quick Links -->
    <x-card>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Links</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <a href="{{ route('profile.show') }}" class="group relative rounded-xl border-2 border-gray-200 bg-white p-6 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg bg-indigo-100 group-hover:bg-indigo-200 flex items-center justify-center transition-colors">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">My Profile</p>
                            <p class="text-sm text-gray-500 mt-1">Manage your account settings</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('password.request') }}" class="group relative rounded-xl border-2 border-gray-200 bg-white p-6 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg bg-indigo-100 group-hover:bg-indigo-200 flex items-center justify-center transition-colors">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Change Password</p>
                            <p class="text-sm text-gray-500 mt-1">Update your password</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profile.show') }}#two-factor" class="group relative rounded-xl border-2 border-gray-200 bg-white p-6 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg bg-indigo-100 group-hover:bg-indigo-200 flex items-center justify-center transition-colors">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Security Settings</p>
                            <p class="text-sm text-gray-500 mt-1">Two-factor authentication</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </x-card>
</div>
@endsection
