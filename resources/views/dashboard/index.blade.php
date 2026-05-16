@extends('layouts.app')

@section('content')

<h1 class="mb-6 text-2xl font-bold text-gray-800">📊 Dashboard</h1>

@if(auth()->user()->isFarmer())
<div class="px-4 py-2 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50">
    🌾 You are viewing <strong>your own data only</strong>.
</div>
@endif

<div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-2 xl:grid-cols-4">
    <div class="p-5 bg-white border-l-4 border-green-500 shadow rounded-xl">
        <p class="mb-1 text-sm text-gray-500">Total Livestock</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalLivestock }}</p>
        <a href="{{ route('livestock.index') }}" class="block mt-2 text-xs text-green-600 hover:underline">View all →</a>
    </div>
    <div class="p-5 bg-white border-l-4 border-blue-500 shadow rounded-xl">
        <p class="mb-1 text-sm text-gray-500">Total Owners</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalOwners }}</p>
    </div>
    <div class="p-5 bg-white border-l-4 border-yellow-500 shadow rounded-xl">
        <p class="mb-1 text-sm text-gray-500">Vaccinations This Month</p>
        <p class="text-3xl font-bold text-gray-800">{{ $vaccinationsThisMonth }}</p>
        <a href="{{ route('vaccinations.index') }}" class="block mt-2 text-xs text-yellow-600 hover:underline">View all →</a>
    </div>
    <div class="p-5 bg-white border-l-4 border-red-500 shadow rounded-xl">
        <p class="mb-1 text-sm text-gray-500">Overdue Vaccines</p>
        <p class="text-3xl font-bold text-red-600">{{ $overdueVaccines->count() }}</p>
        <a href="{{ route('vaccinations.index') }}" class="block mt-2 text-xs text-red-600 hover:underline">View all →</a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
    <div class="bg-white shadow rounded-xl">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">⚠️ Overdue Vaccinations</h2>
            <span class="px-2 py-1 text-xs text-red-700 bg-red-100 rounded-full">{{ $overdueVaccines->count() }}</span>
        </div>
        <div class="p-4">
            @forelse($overdueVaccines->take(5) as $v)
            <div class="flex items-center justify-between py-2 text-sm border-b border-gray-50">
                <span class="text-gray-700">{{ $v->vaccine_name }}</span>
                <span class="font-medium text-red-600">
                    {{ \Carbon\Carbon::parse($v->next_due_date)->format('d M Y') }}
                </span>
            </div>
            @empty
            <p class="py-4 text-sm text-center text-gray-400">No overdue vaccinations ✅</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white shadow rounded-xl">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">📅 Upcoming (7 Days)</h2>
            <span class="px-2 py-1 text-xs text-yellow-700 bg-yellow-100 rounded-full">{{ $upcomingVaccines->count() }}</span>
        </div>
        <div class="p-4">
            @forelse($upcomingVaccines as $v)
            <div class="flex items-center justify-between py-2 text-sm border-b border-gray-50">
                <span class="text-gray-700">{{ $v->vaccine_name }}</span>
                <span class="font-medium text-yellow-600">
                    {{ \Carbon\Carbon::parse($v->next_due_date)->format('d M Y') }}
                </span>
            </div>
            @empty
            <p class="py-4 text-sm text-center text-gray-400">No upcoming vaccinations</p>
            @endforelse
        </div>
    </div>
</div>

<div class="bg-white shadow rounded-xl">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">🔄 Recent Trades</h2>
        <a href="{{ route('trades.index') }}" class="text-sm text-green-600 hover:underline">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Animal</th>
                    <th class="px-4 py-3 text-left">From</th>
                    <th class="px-4 py-3 text-left">To</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Price</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentTrades as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $t->livestock_id }}</td>
                    <td class="px-4 py-3">{{ $t->from_owner_id }}</td>
                    <td class="px-4 py-3">{{ $t->to_owner_id }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($t->transfer_date)->format('d M Y') }}</td>
                    <td class="px-4 py-3 font-medium">Rs. {{ number_format($t->price, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">No trades yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection