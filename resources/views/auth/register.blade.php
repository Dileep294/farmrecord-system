<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — FarmRecord System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen py-8 bg-gray-100">

<div class="w-full max-w-md">

    <!-- Header -->
    <div class="mb-8 text-center">
        <div class="mb-3 text-6xl">🐄</div>
        <h1 class="text-3xl font-bold text-gray-800">FarmRecord System</h1>
        <p class="mt-1 text-gray-500">Create your account</p>
    </div>

    <!-- Card -->
    <div class="p-8 bg-white shadow-lg rounded-2xl">
        <h2 class="mb-6 text-xl font-bold text-center text-gray-800">Register</h2>

        @if ($errors->any())
        <div class="px-4 py-3 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       placeholder="John Doe" required autofocus>
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       placeholder="you@example.com" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Password *</label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       placeholder="Min 8 characters" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Confirm Password *</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       placeholder="Repeat password" required>
        </div>

            <div class="mb-6">
            <label class="block mb-1 text-sm font-medium text-gray-700">Role *</label>
            <select name="role"
                    class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>

                <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : '' }}>
                    🌾 Farmer
                </option>

                @php
                    $adminExists     = \App\Models\User::where('role', 'admin')->exists();
                    $authorityExists = \App\Models\User::where('role', 'authority')->exists();
                @endphp

                @if(!$authorityExists)
                <option value="authority" {{ old('role') == 'authority' ? 'selected' : '' }}>
                    🏛️ Authority
                </option>
                @endif

                @if(!$adminExists)
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                    ⚙️ Admin
                </option>
                @endif

            </select>

            <p class="mt-1 text-xs text-gray-400">
                Farmer = own data only · Authority = all data · Admin = full access
            </p>

            @if($adminExists && $authorityExists)
            <p class="px-2 py-1 mt-1 text-xs text-yellow-600 border border-yellow-200 rounded bg-yellow-50">
                ⚠️ Admin and Authority accounts are already registered. Only Farmer registration is available.
            </p>
            @elseif($adminExists)
            <p class="px-2 py-1 mt-1 text-xs text-yellow-600 border border-yellow-200 rounded bg-yellow-50">
                ⚠️ Admin account already exists.
            </p>
            @elseif($authorityExists)
            <p class="px-2 py-1 mt-1 text-xs text-yellow-600 border border-yellow-200 rounded bg-yellow-50">
                ⚠️ Authority account already exists.
            </p>
            @endif

        </div>

            <button type="submit"
                    class="w-full py-3 text-sm font-semibold text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                Create Account
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-green-600 hover:underline">
                    Sign in
                </a>
            </p>
        </div>
    </div>

</div>

</body>
</html>