@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Patient Records</h2>
    <a href="{{ route('patients.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Patient</a>
    <div class="mt-4">
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Age</th>
                    <th class="px-4 py-2 border">Gender</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td class="px-4 py-2 border">{{ $patient->name }}</td>
                        <td class="px-4 py-2 border">{{ $patient->age }}</td>
                        <td class="px-4 py-2 border">{{ $patient->gender }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('patients.edit', $patient->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
