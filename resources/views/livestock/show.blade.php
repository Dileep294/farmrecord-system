@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🐄 Animal Details</h1>
    <a href="{{ route('livestock.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <div class="p-6 text-center bg-white shadow rounded-xl">
        <div class="mb-3 text-6xl">🐄</div>
        <h2 class="text-xl font-bold text-gray-800">{{ $animal->tag_number }}</h2>
        @php
            $colors = [
                'active'      => 'bg-green-100 text-green-700',
                'transferred' => 'bg-yellow-100 text-yellow-700',
                'deceased'    => 'bg-red-100 text-red-700'
            ];
        @endphp
        <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-medium {{ $colors[$animal->status] ?? '' }}">
            {{ ucfirst($animal->status) }}
        </span>
        <div class="mt-4 space-y-2 text-sm text-left">
            <div class="flex justify-between pb-2 border-b">
                <span class="text-gray-500">Species</span>
                <span class="font-medium">{{ $animal->species }}</span>
            </div>
            <div class="flex justify-between pb-2 border-b">
                <span class="text-gray-500">Breed</span>
                <span class="font-medium">{{ $animal->breed }}</span>
            </div>
            <div class="flex justify-between pb-2 border-b">
                <span class="text-gray-500">Age</span>
                <span class="font-medium">{{ $animal->age }} yrs</span>
            </div>
            <div class="flex justify-between pb-2 border-b">
                <span class="text-gray-500">Colour</span>
                <span class="font-medium">{{ $animal->colour ?? '-' }}</span>
            </div>
        </div>
        <a href="{{ route('livestock.edit', $animal->id) }}"
           class="block px-4 py-2 mt-4 text-sm text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200">
            Edit Animal
        </a>
    </div>

    <div class="space-y-4 lg:col-span-2">

        @if(auth()->user()->isAdmin())
        <div class="p-5 bg-white shadow rounded-xl">
            <h3 class="mb-3 font-semibold text-gray-800">🔄 Transfer Ownership</h3>
            <form method="POST" action="{{ route('livestock.transfer', $animal->id) }}">
                @csrf
                <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                    <select name="new_owner_id"
                            class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                            required>
                        <option value="">— New Owner —</option>
                        @foreach($owners as $o)
                            @if((string)$o->id !== (string)$animal->owner_id)
                            <option value="{{ $o->id }}">{{ $o->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="number" name="price" placeholder="Price (Rs.)" min="0" step="0.01"
                           class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <input type="text" name="notes" placeholder="Notes"
                           class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
                <button type="submit"
                        class="px-4 py-2 mt-3 text-sm text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                    Transfer Ownership
                </button>
            </form>
        </div>
        @endif

        <div class="bg-white shadow rounded-xl">
            <div class="flex justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">💉 Vaccination History</h3>
                <a href="{{ route('vaccinations.create') }}" class="text-sm text-green-600 hover:underline">+ Add</a>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Vaccine</th>
                        <th class="px-4 py-3 text-left">Given</th>
                        <th class="px-4 py-3 text-left">Next Due</th>
                        <th class="px-4 py-3 text-left">By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($vaccinations as $v)
                    <tr>
                        <td class="px-4 py-3">{{ $v->vaccine_name }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($v->date_given)->format('d M Y') }}</td>
                        <td class="px-4 py-3 {{ \Carbon\Carbon::parse($v->next_due_date)->isPast() ? 'text-red-600 font-semibold' : '' }}">
                            {{ \Carbon\Carbon::parse($v->next_due_date)->format('d M Y') }}
                            @if(\Carbon\Carbon::parse($v->next_due_date)->isPast())
                            <span class="px-1 ml-1 text-xs text-red-600 bg-red-100 rounded">Overdue</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $v->administered_by }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-400">No vaccinations recorded.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white shadow rounded-xl">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">📋 Ownership History</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">From</th>
                        <th class="px-4 py-3 text-left">To</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($history as $h)
                    <tr>
                        <td class="px-4 py-3">{{ $h->from_owner_id }}</td>
                        <td class="px-4 py-3">{{ $h->to_owner_id }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($h->transfer_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3">Rs. {{ number_format($h->price, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-400">No transfers recorded.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection