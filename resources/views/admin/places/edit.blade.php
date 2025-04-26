@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Edit Place</h2>
<form action="{{ route('places.update', $place) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" name="name" id="name" value="{{ $place->name }}" class="w-full mt-1 p-2 border rounded" required>
    </div>
    <div>
        <label for="type" class="block text-sm font-medium">Type</label>
        <select name="type" id="type" class="w-full mt-1 p-2 border rounded">
            @foreach(['resort','restaurant','market','port','bank','fortress','church','park'] as $type)
                <option value="{{ $type }}" @selected($place->type === $type)>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="latitude" class="block text-sm font-medium">Latitude</label>
        <input type="text" name="latitude" id="latitude" value="{{ $place->latitude }}" class="w-full mt-1 p-2 border rounded" required>
    </div>
    <div>
        <label for="longitude" class="block text-sm font-medium">Longitude</label>
        <input type="text" name="longitude" id="longitude" value="{{ $place->longitude }}" class="w-full mt-1 p-2 border rounded" required>
    </div>
    <div>
        <label for="photos" class="block text-sm font-medium">Upload Photos</label>
        <input type="file" name="photos[]" id="photos" multiple class="w-full mt-1 p-2 border rounded">
    </div>
    

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
</form>
@endsection

{{-- // Update places index table with status toggle button --}}
<td class="px-4 py-2">
    <form action="{{ route('places.toggle', $place) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <button type="submit" class="text-sm px-2 py-1 rounded {{ $place->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
            {{ $place->is_active ? 'Active' : 'Inactive' }}
        </button>
    </form>
</td>
