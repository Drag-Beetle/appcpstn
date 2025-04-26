@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Submit Review (Test)</h2>

@if(session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded shadow mb-4">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.reviews.store') }}" method="POST" class="max-w-md bg-white dark:bg-gray-800 p-6 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Place</label>
        <select name="place_id" class="w-full border rounded px-3 py-2">
            @foreach ($places as $place)
                <option value="{{ $place->id }}">{{ $place->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Rating</label>
        <input type="number" name="rating" min="1" max="5" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-white">Comment</label>
        <textarea name="comment" rows="4" class="w-full border rounded px-3 py-2"></textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Review</button>
</form>
@endsection
