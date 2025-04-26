@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Edit User</h2>
<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PATCH')

    <div>
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full mt-1 p-2 border rounded">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium">Email</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full mt-1 p-2 border rounded">
    </div>

    <div>
        <label for="role_id" class="block text-sm font-medium">Role</label>
        <select name="role_id" id="role_id" class="w-full mt-1 p-2 border rounded">
            @foreach ($roles as $id => $name)
                <option value="{{ $id }}" @selected($user->role_id == $id)>{{ ucfirst($name) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="password" class="block text-sm font-medium">New Password (optional)</label>
        <input type="password" name="password" id="password" class="w-full mt-1 p-2 border rounded">
    </div>
    
    <div>
        <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full mt-1 p-2 border rounded">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
</form>
@endsection
