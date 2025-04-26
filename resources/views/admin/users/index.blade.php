@extends('layouts.app')

@section('content')
@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded shadow">
        {{ session('success') }}
    </div>
@endif

<h2 class="text-2xl font-bold mb-6">Manage Users</h2>

<form method="GET" action="" class="flex flex-wrap gap-4 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email" class="w-full md:w-1/3 px-4 py-2 border rounded" />

    <select name="role" class="w-full md:w-1/4 px-4 py-2 border rounded">
        <option value="">All Roles</option>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(request('role') == $role->id)>{{ ucfirst($role->name) }}</option>
        @endforeach
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
</form>

<table class="w-full text-left table-auto bg-white dark:bg-gray-800">
    <thead>
        <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr class="border-b border-gray-100 dark:border-gray-700">
            <td class="px-4 py-2">{{ $user->name }}</td>
            <td class="px-4 py-2">{{ $user->email }}</td>
            <td class="px-4 py-2">
                @php
                    $roleColor = match($user->role->name) {
                        'admin' => 'bg-blue-100 text-blue-800',
                        'employee' => 'bg-yellow-100 text-yellow-800',
                        'owner' => 'bg-purple-100 text-purple-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <span class="px-2 py-1 rounded text-sm font-medium {{ $roleColor }}">
                    {{ ucfirst($user->role->name) }}
                </span>
            </td>
            <td class="px-4 py-2">
                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="text-sm px-2 py-1 rounded {{ $user->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </button>
                </form>
            </td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('admin.users.show', $user->id) }}" class="text-indigo-500 hover:underline">Show</a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-6">
    {{ $users->withQueryString()->links() }}
</div>
@endsection
