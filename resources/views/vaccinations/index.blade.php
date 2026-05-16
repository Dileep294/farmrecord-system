@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">💉 Vaccinations</h1>
    <a href="{{ route('vaccinations.create') }}"
       class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
        + Add Record
    </a>
</div>

<div class="overflow-hidden bg-white shadow rounded-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Animal Tag</th>
                    <th class="px-4 py-3 text-left">Vaccine</th>
                    <th class="px-4 py-3 text-left">Date Given</th>
                    <th class="px-4 py-3 text-left">Next Due</th>
                    <th class="px-4 py-3 text-left">By</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($vaccinations as $i => $v)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ $v->livestock_id }}</td>
                    <td class="px-4 py-3">{{ $v->vaccine_name }}</td>
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($v->date_given)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 {{ \Carbon\Carbon::parse($v->next_due_date)->isPast() ? 'text-red-600 font-semibold' : '' }}">
                        {{ \Carbon\Carbon::parse($v->next_due_date)->format('d M Y') }}
                        @if(\Carbon\Carbon::parse($v->next_due_date)->isPast())
                        <span class="px-1 ml-1 text-xs text-red-600 bg-red-100 rounded">Overdue</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $v->administered_by }}</td>
                    <td class="px-4 py-3">
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('vaccinations.destroy', $v->id) }}"
                              onsubmit="return confirm('Delete this record?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 text-xs text-red-700 bg-red-100 rounded hover:bg-red-200">
                                Delete
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                        No vaccination records found.
                        <a href="{{ route('vaccinations.create') }}" class="ml-1 text-green-600 hover:underline">Add first record →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $vaccinations->links() }}
    </div>
</div>

@endsection