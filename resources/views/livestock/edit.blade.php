@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Animal</h1>
    <a href="{{ route('livestock.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="max-w-3xl p-6 bg-white shadow rounded-xl">
    <form method="POST" action="{{ route('livestock.update', $animal->id) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Tag Number *</label>
                <input type="text" name="tag_number" value="{{ $animal->tag_number }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Species *</label>
                <select name="species" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    @foreach(['Cow','Buffalo','Goat','Sheep','Horse','Camel','Pig','Poultry'] as $s)
                    <option {{ $animal->species == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Breed *</label>
                <input type="text" name="breed" value="{{ $animal->breed }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Age (years)</label>
                <input type="number" name="age" value="{{ $animal->age }}" min="0"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Colour</label>
                <input type="text" name="colour" value="{{ $animal->colour }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    @foreach(['active','transferred','deceased'] as $s)
                    <option {{ $animal->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                Update Animal
            </button>
        </div>
    </form>
</div>

@endsection