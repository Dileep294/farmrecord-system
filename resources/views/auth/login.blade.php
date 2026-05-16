<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FarmRecord System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

<div class="w-full max-w-md">

    <!-- Header -->
    <div class="mb-8 text-center">
        <div class="mb-3 text-6xl">🐄</div>
        <h1 class="text-3xl font-bold text-gray-800">FarmRecord System</h1>
        <p class="mt-1 text-gray-500">Livestock Ownership Database</p>
    </div>

    <!-- Card -->
    <div class="p-8 bg-white shadow-lg rounded-2xl">
        <h2 class="mb-6 text-xl font-bold text-center text-gray-800">Sign in to your account</h2>

        <!-- Session Status -->
        @if (session('status'))
        <div class="px-4 py-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded-lg">
            {{ session('status') }}
        </div>
        @endif

        <!-- Errors -->
        @if ($errors->any())
        <div class="px-4 py-3 mb-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="you@example.com" required autofocus>
            </div>

            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="••••••••" required>
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="text-green-600 border-gray-300 rounded">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-green-600 hover:underline">
                    Forgot password?
                </a>
                @endif
            </div>

            <button type="submit"
                    class="w-full py-3 text-sm font-semibold text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                Sign In
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-green-600 hover:underline">
                    Register here
                </a>
            </p>
        </div>
    </div>

    <p class="mt-6 text-xs text-center text-gray-400">
        FarmRecord System © {{ date('Y') }}
    </p>
</div>

</body>
</html>