@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">My Profile</h2>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow space-y-8">

        <!-- Avatar -->
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <img src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0D8ABC&color=fff' }}" 
                     alt="Avatar" class="object-cover w-full h-full">
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Combined Profile + Password Form -->
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                <textarea name="bio" id="bio" rows="4"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('bio', Auth::user()->bio) }}</textarea>
            </div>

            <hr class="my-6 border-gray-200 dark:border-gray-700">

            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Address Information</h3>

            <!-- Street -->
            <div>
                <label for="street" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street Address</label>
                <input type="text" name="street" id="street" value="{{ old('street', Auth::user()->street) }}"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- City -->
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                <input type="text" name="city" id="city" value="{{ old('city', Auth::user()->city) }}"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Country -->
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                <input type="text" name="country" id="country" value="{{ old('country', Auth::user()->country) }}"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Postal Code -->
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <hr class="my-6 border-gray-200 dark:border-gray-700">

            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Change Password (optional)</h3>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                <input type="password" name="password" id="password"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="Leave blank if not changing">
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="Leave blank if not changing">
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition">
                    Save Changes
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
