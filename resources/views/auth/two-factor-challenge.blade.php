@extends('layouts.auth')

@section('title', 'Two Factor Authentication')

@section('content')
<div>
    <div class="mb-4 text-sm text-gray-600">
        <span x-data="{ recovery: false }">
            <span x-show="! recovery">
                Please confirm access to your account by entering the authentication code provided by your authenticator application.
            </span>
            <span x-show="recovery" x-cloak>
                Please confirm access to your account by entering one of your emergency recovery codes.
            </span>
        </span>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="font-medium text-sm text-red-600">Whoops! Something went wrong.</div>
            <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login') }}" x-data="{ recovery: false }">
        @csrf

        <!-- Code -->
        <div x-show="! recovery">
            <label for="code" class="block font-medium text-sm text-gray-700">Code</label>
            <input id="code" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
        </div>

        <!-- Recovery Code -->
        <div x-show="recovery" x-cloak>
            <label for="recovery_code" class="block font-medium text-sm text-gray-700">Recovery Code</label>
            <input id="recovery_code" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border">
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                    x-show="! recovery"
                    x-on:click="
                        recovery = true;
                        $nextTick(() => { $refs.recovery_code.focus() })
                    ">
                Use a recovery code
            </button>

            <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                    x-show="recovery"
                    x-cloak
                    x-on:click="
                        recovery = false;
                        $nextTick(() => { $refs.code.focus() })
                    ">
                Use an authentication code
            </button>

            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Log in
            </button>
        </div>
    </form>
</div>

<!-- Alpine.js for toggle -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
