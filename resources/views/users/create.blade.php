@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">⚙️ Add User</h1>
    <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="max-w-lg p-6 bg-white shadow rounded-xl">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="space-y-4">

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Password *</label>
                <input type="password" name="password"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       minlength="8" required>
                <p class="mt-1 text-xs text-gray-400">Minimum 8 characters.</p>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Role *</label>
                <select name="role"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                        required>
                    <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : '' }}>
                        🌾 Farmer
                    </option>
                    <option value="authority" {{ old('role') == 'authority' ? 'selected' : '' }}>
                        🏛️ Authority
                    </option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                        ⚙️ Admin
                    </option>
                </select>
            </div>

            <div class="p-3 text-xs text-yellow-800 border border-yellow-200 rounded-lg bg-yellow-50">
                <strong>Role permissions:</strong><br>
                🌾 Farmer — sees own data only<br>
                🏛️ Authority — sees all data, manages owners<br>
                ⚙️ Admin — full access including user management
            </div>

        </div>
        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                Create User
            </button>
        </div>
    </form>
</div>

@endsection