@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Add New Patient</h2>

    <form action="{{ route('patients.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium">Patient Name</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded" value="{{ old('name') }}" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="age" class="block text-sm font-medium">Age</label>
            <input type="number" name="age" id="age" class="w-full p-2 border rounded" value="{{ old('age') }}" required>
            @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="gender" class="block text-sm font-medium">Gender</label>
            <select name="gender" id="gender" class="w-full p-2 border rounded" required>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Patient</button>
        </div>
    </form>
</div>
@endsection
