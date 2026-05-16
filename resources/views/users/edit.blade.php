@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">✏️ Edit User</h1>
    <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="max-w-lg p-6 bg-white shadow rounded-xl">
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf @method('PUT')
        <div class="space-y-4">

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="name" value="{{ $user->name }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Email *</label>
                <input type="email" name="email" value="{{ $user->email }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                    New Password
                    <span class="font-normal text-gray-400">(leave blank to keep current)</span>
                </label>
                <input type="password" name="password"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       minlength="8">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Role *</label>
                <select name="role"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                        required>
                    <option value="farmer" {{ $user->role == 'farmer' ? 'selected' : '' }}>
                        🌾 Farmer
                    </option>
                    <option value="authority" {{ $user->role == 'authority' ? 'selected' : '' }}>
                        🏛️ Authority
                    </option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                        ⚙️ Admin
                    </option>
                </select>
            </div>

        </div>
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('users.index') }}"
               class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                Update User
            </button>
        </div>
    </form>
</div>

@endsection