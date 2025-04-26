@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Manage Places</h2>

<form method="GET" action="" class="flex flex-wrap gap-4 mb-4">
    <input type="text" name="city" value="{{ request('city') }}" placeholder="Filter by city" class="border p-2 rounded w-full md:w-1/4">

    <select name="status" class="border p-2 rounded w-full md:w-1/4">
        <option value="">All Status</option>
        <option value="active" @selected(request('status') === 'active')>Active</option>
        <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Apply</button>
</form>

<a href="/create/" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Place</a>

<table class="w-full text-left table-auto bg-white dark:bg-gray-800">
    <thead>
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Type</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Created By</th>
            <th class="px-4 py-2">Updated By</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($places as $place)
        <tr class="border-b border-gray-100 dark:border-gray-700">
            <td class="px-4 py-2">
                <div class="flex items-center gap-2">
                    @php $primaryPhoto = $place->photos->first(); @endphp
                    @if ($primaryPhoto)
                        <img src="{{ asset('storage/' . $primaryPhoto->image_url) }}" alt="{{ $place->name }}" class="w-10 h-10 object-cover rounded">
                    @endif
                    <span>{{ $place->name }}</span>
                </div>
            </td>
            <td class="px-4 py-2">{{ $place->type }}</td>
            <td class="px-4 py-2">{{ $place->is_active ? 'Active' : 'Inactive' }}</td>
            <td class="px-4 py-2">{{ $place->creator->name ?? '—' }}</td>
            <td class="px-4 py-2">{{ $place->updater->name ?? '—' }}</td>
            <td class="px-4 py-2">
                <a href="{{ route('places.edit', $place->id) }}" class="text-blue-500 hover:underline">Edit</a>
                <a href="{{ route('places.photos', $place->id) }}" class="text-purple-500 hover:underline mr-2">Gallery</a>
                <form action="{{ route('places.update', $place->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
