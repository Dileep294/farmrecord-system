@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🐄 Livestock</h1>
    <a href="{{ route('livestock.create') }}"
       class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
        + Add Animal
    </a>
</div>

<div class="overflow-hidden bg-white shadow rounded-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Tag</th>
                    <th class="px-4 py-3 text-left">Species</th>
                    <th class="px-4 py-3 text-left">Breed</th>
                    <th class="px-4 py-3 text-left">Age</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($livestock as $i => $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $a->tag_number }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $a->species }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $a->breed }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $a->age }} yrs</td>
                    <td class="px-4 py-3">
                        @php
                            $colors = [
                                'active'      => 'bg-green-100 text-green-700',
                                'transferred' => 'bg-yellow-100 text-yellow-700',
                                'deceased'    => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$a->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('livestock.show', $a->id) }}"
                               class="px-3 py-1 text-xs text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                                View
                            </a>
                            <a href="{{ route('livestock.edit', $a->id) }}"
                               class="px-3 py-1 text-xs text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('livestock.destroy', $a->id) }}"
                                  onsubmit="return confirm('Delete this animal?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 text-xs text-red-700 bg-red-100 rounded hover:bg-red-200">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                        No livestock found.
                        <a href="{{ route('livestock.create') }}" class="ml-1 text-green-600 hover:underline">Add first animal →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $livestock->links() }}
    </div>
</div>

@endsection