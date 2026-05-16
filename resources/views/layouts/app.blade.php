<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmRecord System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">

<!-- Navbar -->
<nav class="flex items-center justify-between px-6 py-4 text-white bg-green-700 shadow">
    <div class="flex items-center gap-3">
        <span class="text-2xl">🐄</span>
        <span class="text-lg font-bold tracking-wide">FarmRecord System</span>
    </div>
    <div class="flex items-center gap-4 text-sm">
        <span class="px-3 py-1 bg-green-800 rounded-full">
            {{ ucfirst(auth()->user()->role) }}
        </span>
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="px-3 py-1 font-semibold text-green-700 bg-white rounded hover:bg-gray-100">
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="flex flex-col w-56 gap-1 px-3 pt-6 bg-white shadow-md">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium {{ request()->routeIs('dashboard') ? 'bg-green-100 text-green-700' : '' }}">
            📊 Dashboard
        </a>

        @if(auth()->user()->canSeeAllData())
        <a href="{{ route('owners.index') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium {{ request()->routeIs('owners.*') ? 'bg-green-100 text-green-700' : '' }}">
            👤 Owners
        </a>
        @endif

        <a href="{{ route('livestock.index') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium {{ request()->routeIs('livestock.*') ? 'bg-green-100 text-green-700' : '' }}">
            🐄 Livestock
        </a>

        <a href="{{ route('vaccinations.index') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium {{ request()->routeIs('vaccinations.*') ? 'bg-green-100 text-green-700' : '' }}">
            💉 Vaccinations
        </a>

        <a href="{{ route('trades.index') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium {{ request()->routeIs('trades.*') ? 'bg-green-100 text-green-700' : '' }}">
            🔄 Trades
        </a>

        @if(auth()->user()->isAdmin())
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 font-medium {{ request()->routeIs('users.*') ? 'bg-green-100 text-green-700' : '' }}">
            ⚙️ Users
        </a>
        @endif
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">

        @if(session('success'))
        <div class="flex items-center justify-between px-4 py-3 mb-4 text-green-800 bg-green-100 border border-green-400 rounded-lg">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-lg font-bold text-green-600">&times;</button>
        </div>
        @endif

        @if(session('error'))
        <div class="flex items-center justify-between px-4 py-3 mb-4 text-red-800 bg-red-100 border border-red-400 rounded-lg">
            <span>❌ {{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-lg font-bold text-red-600">&times;</button>
        </div>
        @endif

        @if($errors->any())
        <div class="px-4 py-3 mb-4 text-red-800 bg-red-100 border border-red-400 rounded-lg">
            <ul class="text-sm list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>