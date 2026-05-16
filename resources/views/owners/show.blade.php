@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">👤 Owner Details</h1>
    <a href="{{ route('owners.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <div class="p-6 text-center bg-white shadow rounded-xl">
        <div class="mb-3 text-5xl">👤</div>
        <h2 class="text-xl font-bold text-gray-800">{{ $owner->name }}</h2>
        <p class="mt-1 text-sm text-gray-500">{{ $owner->nic }}</p>
        <hr class="my-4">
        <div class="space-y-3 text-sm text-left">
            <div class="flex justify-between">
                <span class="text-gray-500">Phone</span>
                <span class="font-medium">{{ $owner->phone }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Email</span>
                <span class="font-medium">{{ $owner->email ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Address</span>
                <span class="font-medium text-right">{{ $owner->address ?? '-' }}</span>
            </div>
        </div>
        <a href="{{ route('owners.edit', $owner->id) }}"
           class="block px-4 py-2 mt-4 text-sm text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200">
            Edit Owner
        </a>
    </div>

    <div class="bg-white shadow lg:col-span-2 rounded-xl">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">🐄 Livestock ({{ $livestock->count() }})</h3>
            <a href="{{ route('livestock.create') }}" class="text-sm text-green-600 hover:underline">+ Add Animal</a>
        </div>
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Tag</th>
                    <th class="px-4 py-3 text-left">Species</th>
                    <th class="px-4 py-3 text-left">Breed</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($livestock as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $a->tag_number }}</td>
                    <td class="px-4 py-3">{{ $a->species }}</td>
                    <td class="px-4 py-3">{{ $a->breed }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $a->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('livestock.show', $a->id) }}"
                           class="text-xs text-green-600 hover:underline">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                        No animals registered for this owner.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection