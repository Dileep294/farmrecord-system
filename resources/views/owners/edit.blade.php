@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Owner</h1>
    <a href="{{ route('owners.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="max-w-2xl p-6 bg-white shadow rounded-xl">
    <form method="POST" action="{{ route('owners.update', $owner->id) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="name" value="{{ $owner->name }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">NIC *</label>
                <input type="text" name="nic" value="{{ $owner->nic }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Phone *</label>
                <input type="text" name="phone" value="{{ $owner->phone }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $owner->email }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" rows="2"
                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">{{ $owner->address }}</textarea>
            </div>

        </div>
        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                Update Owner
            </button>
        </div>
    </form>
</div>

@endsection