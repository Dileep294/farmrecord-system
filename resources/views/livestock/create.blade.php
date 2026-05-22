@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🐄 Register Animal</h1>
    <a href="{{ route('livestock.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="max-w-3xl p-6 bg-white shadow rounded-xl">
    <form method="POST" action="{{ route('livestock.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Tag Number *</label>
                <input type="text" name="tag_number" value="{{ old('tag_number') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Owner *</label>
                <select name="owner_id"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <option value="">— Select Owner —</option>
                    @foreach($owners as $o)
                    <option value="{{ $o->id }}" {{ old('owner_id') == $o->id ? 'selected' : '' }}>
                        {{ $o->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Species *</label>
                <select name="species"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                    <option value="">— Select —</option>
                    @foreach(['Cow','Buffalo','Goat','Sheep','Horse','Camel','Pig','Poultry'] as $s)
                    <option {{ old('species') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Breed *</label>
                <input type="text" name="breed" value="{{ old('breed') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Age (years) *</label>
                <input type="number" name="age" value="{{ old('age') }}" min="0" max="50"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Colour</label>
                <input type="text" name="colour" value="{{ old('colour') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Photo</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                <p class="mt-1 text-xs text-gray-400">Max 2MB. JPG, PNG, WEBP.</p>
            </div>

            {{-- Admin only: assign to farmer --}}
            @if(auth()->user()->isAdmin())
            <div class="p-4 border border-blue-200 md:col-span-2 bg-blue-50 rounded-xl">
                <label class="block mb-1 text-sm font-medium text-blue-800">
                    🌾 Assign to Farmer
                    <span class="font-normal text-blue-500">(animal will appear on farmer's dashboard)</span>
                </label>
                <select name="farmer_id"
                        class="w-full px-3 py-2 text-sm border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Leave blank to assign to Admin —</option>
                    @foreach($farmers as $f)
                    <option value="{{ $f->id }}" {{ old('farmer_id') == $f->id ? 'selected' : '' }}>
                        {{ $f->name }} ({{ $f->email }})
                    </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-blue-500">
                    Select a farmer so this animal shows on their livestock dashboard.
                </p>
            </div>
            @endif

        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                Save Animal
            </button>
        </div>
    </form>
</div>

@endsection