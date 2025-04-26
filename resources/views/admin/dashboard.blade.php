@extends('layouts.app')

@section('content')
@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded shadow">
        {{ session('success') }}
    </div>
@endif

<h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>

<!-- Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <a href="/places" class="block p-4 bg-white dark:bg-gray-800 shadow rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-300">Total Places</p>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalPlaces }}</h3>
    </a>

    <a href="/users" class="block p-4 bg-white dark:bg-gray-800 shadow rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-300">Registered Users</p>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</h3>
    </a>

    <a href="/places?status=inactive" class="block p-4 bg-white dark:bg-gray-800 shadow rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-300">Pending Place Submissions</p>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingPlaces }}</h3>
    </a>

    <a href="/admin/reviews" class="block p-4 bg-white dark:bg-gray-800 shadow rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
        <p class="text-sm text-gray-500 dark:text-gray-300">Total Reviews</p>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalReviews }}</h3>
    </a>

    <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
        <p class="text-sm text-gray-500 dark:text-gray-300">Most Reviewed Place</p>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $topPlace->name ?? 'N/A' }}</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $topPlace->reviews_count ?? 0 }} reviews</p>
    </div>
</div>

<!-- Recent Reviews -->
<div class="bg-white dark:bg-gray-800 p-6 shadow rounded-lg">  
    <h4 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Recent Reviews</h4>
    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($recentReviews as $review)
            <li class="flex items-start gap-3 py-3">
                @php $thumb = $review->place->photos()->where('is_primary', true)->first(); @endphp
                @if ($thumb)
                    <img src="{{ asset('storage/' . $thumb->image_url) }}" alt="" class="w-10 h-10 rounded object-cover">
                @endif
                <div class="flex-1">
                    <p class="text-sm text-gray-800 dark:text-gray-100">"{{ $review->comment }}"</p>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        <span class="font-medium">Rating:</span>
                        <span class="px-2 py-0.5 rounded text-xs font-semibold
                            {{ $review->rating >= 4 ? 'bg-green-100 text-green-800' : ($review->rating >= 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $review->rating }}
                        </span>
                        <span class="ml-2">Place: {{ $review->place->name }}</span>
                        <span class="ml-2">By: {{ $review->user->name }}</span>
                        <span class="ml-2 italic">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </li>
        @empty
            <li class="text-sm text-gray-500 dark:text-gray-400">No reviews yet.</li>
        @endforelse
    </ul>
</div>
@endsection
