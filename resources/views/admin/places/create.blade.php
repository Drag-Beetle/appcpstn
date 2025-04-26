@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Add New Place</h2>
<form action="{{ route('places.store') }}" method="POST" class="space-y-6">
    @csrf
    <div>
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" name="name" id="name" class="w-full mt-1 p-2 border rounded" required>
    </div>
    <div>
        <label for="type" class="block text-sm font-medium">Type</label>
        <select name="type" id="type" class="w-full mt-1 p-2 border rounded">
            @foreach(['resort','restaurant','market','port','bank','fortress','church','park'] as $type)
                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="latitude" class="block text-sm font-medium">Latitude</label>
        <input type="text" name="latitude" id="latitude" class="w-full mt-1 p-2 border rounded" required>
    </div>
    <div>
        <label for="longitude" class="block text-sm font-medium">Longitude</label>
        <input type="text" name="longitude" id="longitude" class="w-full mt-1 p-2 border rounded" required>
    </div>
    <div>
        <label for="photos" class="block text-sm font-medium">Upload Photos</label>
        <input type="file" name="photos[]" id="photos" multiple class="w-full mt-1 p-2 border rounded">
    </div>
    
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
</form>
@endsection