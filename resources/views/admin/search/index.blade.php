@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Search Results</h2>

<form method="GET" action="{{ route('admin.search') }}" class="mb-6">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search users, places, reviews..."
           class="w-full md:w-1/2 px-4 py-2 border rounded shadow" autofocus>
</form>

@if(!request('q'))
    <p class="text-gray-500">Enter a keyword above to search across users, places, and reviews.</p>
    @return
@endif

<div class="space-y-8">
    {{-- USERS --}}
    <div>
        <h3 class="text-lg font-semibold mb-2">Users</h3>
        @forelse ($users as $user)
            <div class="p-2 border-b">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline">
                    {{ $user->name }}
                </a>
                <div class="text-sm text-gray-500">{{ $user->email }}</div>
            </div>
        @empty
            <div class="text-sm text-gray-400">No matching users found.</div>
        @endforelse
    </div>

    {{-- PLACES --}}
    <div>
        <h3 class="text-lg font-semibold mb-2">Places</h3>
        @forelse ($places as $place)
            <div class="p-2 border-b">
                <a href="{{ route('places.edit', $place->id) }}" class="text-blue-600 hover:underline">
                    {{ $place->name }}
                </a>
                <div class="text-sm text-gray-500">{{ $place->city ?? 'Unknown City' }}</div>
            </div>
        @empty
            <div class="text-sm text-gray-400">No matching places found.</div>
        @endforelse
    </div>

    {{-- REVIEWS --}}
    <div>
        <h3 class="text-lg font-semibold mb-2">Reviews</h3>
        @forelse ($reviews as $review)
            <div class="p-2 border-b">
                <div class="text-sm italic text-gray-800 dark:text-gray-100">
                    "{{ Str::limit($review->comment, 80) }}"
                </div>
                <div class="text-xs text-gray-500">
                    Rating: {{ $review->rating }} | Place: {{ $review->place->name ?? '—' }}
                </div>
            </div>
        @empty
            <div class="text-sm text-gray-400">No matching reviews found.</div>
        @endforelse
    </div>
</div>
@endsection
