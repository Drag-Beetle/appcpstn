@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Edit Profile</h2>

<form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('PATCH')

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
               class="w-full border px-4 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
               class="w-full border px-4 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
               class="w-full border px-4 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <label>New Password (leave blank to keep current)</label>
        <input type="password" name="password"
               class="w-full border px-4 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation"
               class="w-full border px-4 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update Profile
        </button>
    </div>
</form>
@endsection
