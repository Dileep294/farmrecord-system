@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">👤 Owners</h1>
    <a href="{{ route('owners.create') }}"
       class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
        + Add Owner
    </a>
</div>

<div class="overflow-hidden bg-white shadow rounded-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">NIC</th>
                    <th class="px-4 py-3 text-left">Phone</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($owners as $i => $o)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $o->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $o->nic }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $o->phone }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $o->email ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('owners.show', $o->id) }}"
                               class="px-3 py-1 text-xs text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                                View
                            </a>
                            <a href="{{ route('owners.edit', $o->id) }}"
                               class="px-3 py-1 text-xs text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                                Edit
                            </a>
                            @if(auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('owners.destroy', $o->id) }}"
                                  onsubmit="return confirm('Delete this owner?')">
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
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                        No owners found.
                        <a href="{{ route('owners.create') }}" class="ml-1 text-green-600 hover:underline">Add first owner →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $owners->links() }}
    </div>
</div>

@endsection