@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">💉 Add Vaccination</h1>
    <a href="{{ route('vaccinations.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>
</div>

<div class="max-w-2xl p-6 bg-white shadow rounded-xl">
    <form method="POST" action="{{ route('vaccinations.store') }}">
        @csrf
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <div class="md:col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Animal *</label>
                <select name="livestock_id"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                        required>
                    <option value="">— Select Animal —</option>
                    @foreach($animals as $a)
                    <option value="{{ $a->id }}">
                        {{ $a->tag_number }} — {{ $a->species }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Vaccine Name *</label>
                <input type="text" name="vaccine_name" value="{{ old('vaccine_name') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Administered By *</label>
                <input type="text" name="administered_by" value="{{ old('administered_by') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Date Given *</label>
                <input type="date" name="date_given" value="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Next Due Date *</label>
                <input type="date" name="next_due_date"
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                       required>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" rows="2"
                          class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">{{ old('notes') }}</textarea>
            </div>

        </div>
        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                Save Record
            </button>
        </div>
    </form>
</div>

@endsection