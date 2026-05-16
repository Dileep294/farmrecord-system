@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🔄 Trade Details</h1>
    <a href="{{ route('trades.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="max-w-lg p-6 bg-white shadow rounded-xl">
    <table class="w-full text-sm">
        <tr class="border-b">
            <th class="w-1/3 py-3 text-left text-gray-500">Animal ID</th>
            <td class="py-3 font-medium">{{ $trade->livestock_id }}</td>
        </tr>
        <tr class="border-b">
            <th class="py-3 text-left text-gray-500">From Owner</th>
            <td class="py-3">{{ $trade->from_owner_id }}</td>
        </tr>
        <tr class="border-b">
            <th class="py-3 text-left text-gray-500">To Owner</th>
            <td class="py-3">{{ $trade->to_owner_id }}</td>
        </tr>
        <tr class="border-b">
            <th class="py-3 text-left text-gray-500">Transfer Date</th>
            <td class="py-3">
                {{ \Carbon\Carbon::parse($trade->transfer_date)->format('d M Y') }}
            </td>
        </tr>
        <tr class="border-b">
            <th class="py-3 text-left text-gray-500">Price</th>
            <td class="py-3 font-semibold text-green-700">
                Rs. {{ number_format($trade->price, 2) }}
            </td>
        </tr>
        <tr>
            <th class="py-3 text-left text-gray-500">Notes</th>
            <td class="py-3 text-gray-600">{{ $trade->notes ?? '-' }}</td>
        </tr>
    </table>
</div>

@endsection