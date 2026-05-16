@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🔄 Trade Records</h1>
    <a href="{{ route('trades.create') }}"
       class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
        + Record Trade
    </a>
</div>

<div class="overflow-hidden bg-white shadow rounded-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Animal</th>
                    <th class="px-4 py-3 text-left">From Owner</th>
                    <th class="px-4 py-3 text-left">To Owner</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Price</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($trades as $i => $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ $t->livestock_id }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $t->from_owner_id }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $t->to_owner_id }}</td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ \Carbon\Carbon::parse($t->transfer_date)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">
                        Rs. {{ number_format($t->price, 2) }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('trades.show', $t->id) }}"
                               class="px-3 py-1 text-xs text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                                View
                            </a>
                            @if(auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('trades.destroy', $t->id) }}"
                                  onsubmit="return confirm('Delete this trade?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 text-xs text-red-700 bg-red-100 rounded hover:bg-red-200">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                        No trade records found.
                        <a href="{{ route('trades.create') }}" class="ml-1 text-green-600 hover:underline">Record first trade →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $trades->links() }}
    </div>
</div>

@endsection