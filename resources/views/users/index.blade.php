@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">⚙️ Users</h1>
    <a href="{{ route('users.create') }}"
       class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
        + Add User
    </a>
</div>

<div class="overflow-hidden bg-white shadow rounded-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Registered</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $i => $u)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $u->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $u->email }}</td>
                    <td class="px-4 py-3">
                        @php
                            $roleColors = [
                                'admin'     => 'bg-red-100 text-red-700',
                                'authority' => 'bg-blue-100 text-blue-700',
                                'farmer'    => 'bg-green-100 text-green-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $roleColors[$u->role] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ \Carbon\Carbon::parse($u->created_at)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('users.edit', $u->id) }}"
                               class="px-3 py-1 text-xs text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('users.destroy', $u->id) }}"
                                  onsubmit="return confirm('Delete this user?')">
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
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>

@endsection