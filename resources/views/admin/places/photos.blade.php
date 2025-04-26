@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Photo Gallery for {{ $place->name }}</h2>
<form action="{{ route('places.photos.upload', $place->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <label for="photos" class="block text-sm font-medium mb-2">Upload More Photos</label>
    <input type="file" name="photos[]" id="photos" multiple class="mb-4">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
</form>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach ($photos as $photo)
    <div class="relative border rounded shadow overflow-hidden group">
        <a href="{{ asset('storage/' . $photo->image_url) }}" target="_blank">
            <img src="{{ asset('storage/' . $photo->image_url) }}" class="w-full h-40 object-cover hover:opacity-80">
        </a>
        <div class="p-2 text-sm text-gray-700 dark:text-gray-200">
            <div>Size: {{ number_format(Storage::disk('public')->size($photo->image_url) / 1024, 1) }} KB</div>
            <div>Uploaded: {{ $photo->created_at->diffForHumans() }}</div>
        </div>
        <div class="absolute top-2 right-2 flex gap-1">
            <form action="{{ route('places.photos.delete', $photo) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white text-xs px-2 py-1 rounded">Delete</button>
            </form>
            @if (!$photo->is_primary)
            <form action="{{ route('places.photos.primary', $photo) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-yellow-400 text-white text-xs px-2 py-1 rounded">Make Primary</button>
            </form>
            @else
            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">Primary</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
