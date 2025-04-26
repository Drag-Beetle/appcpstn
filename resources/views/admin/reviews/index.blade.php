@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Review Moderation</h2>

@if(session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded shadow mb-4">
        {{ session('success') }}
    </div>
@endif

<form method="GET" class="flex flex-wrap gap-4 mb-4">
    <input type="text" name="user" value="{{ request('user') }}" placeholder="Filter by user name" class="border p-2 rounded w-full md:w-1/4">
    <input type="text" name="place" value="{{ request('place') }}" placeholder="Filter by place name" class="border p-2 rounded w-full md:w-1/4">
    <select name="rating" class="border p-2 rounded w-full md:w-1/4">
        <option value="">All Ratings</option>
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" @selected(request('rating') == $i)>Rating {{ $i }}</option>
        @endfor
    </select>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
</form>

<table class="w-full text-left table-auto bg-white dark:bg-gray-800">
    <thead>
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="px-4 py-2">User</th>
            <th class="px-4 py-2">Place</th>
            <th class="px-4 py-2">Rating</th>
            <th class="px-4 py-2">Comment</th>
            <th class="px-4 py-2">Created</th>
            <th class="px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
        <tr class="border-b border-gray-100 dark:border-gray-700">
            <td class="px-4 py-2">{{ $review->user->name }}</td>
            <td class="px-4 py-2">{{ $review->place->name }}</td>
            <td class="px-4 py-2">
                <span class="inline-block px-2 py-1 rounded text-sm font-semibold
                    {{ $review->rating >= 4 ? 'bg-green-100 text-green-800' : ($review->rating >= 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ $review->rating }}
                    @if ($review->rating <= 2)
                        <span class="ml-1 text-red-500">⚠️</span>
                    @endif
                </span>
            </td>
            <td class="px-4 py-2 text-sm">{{ $review->comment }}</td>
            <td class="px-4 py-2 text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</td>
            <td class="px-4 py-2">
                <button onclick="confirmDelete('{{ route('admin.reviews.destroy', $review->id) }}')" class="text-red-500 hover:underline text-sm">Delete</button>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-sm py-4 text-gray-500">No reviews found.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $reviews->links() }}
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-sm w-full">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Confirm Delete</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Are you sure you want to delete this review?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-3">
                <button type="button" onclick="toggleModal(false)" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelete(action) {
    document.getElementById('deleteForm').action = action;
    toggleModal(true);
}
function toggleModal(show) {
    document.getElementById('deleteModal').classList.toggle('hidden', !show);
}
</script>
@endsection
