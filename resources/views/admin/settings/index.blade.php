@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Settings</h2>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
    @csrf

    <div>
        <label class="block mb-1 text-sm font-medium">Site Name</label>
        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}"
               class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <label class="block mb-1 text-sm font-medium">Admin Email</label>
        <input type="email" name="admin_email" value="{{ old('admin_email', $settings['admin_email'] ?? '') }}"
               class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <label class="block mb-1 text-sm font-medium">Default Language</label>
        <input type="text" name="default_language" value="{{ old('default_language', $settings['default_language'] ?? 'en') }}"
               class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
    </div>

    <div>
        <label class="block mb-1 text-sm font-medium">Theme Mode</label>
        <select name="theme_mode" class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <option value="light" @selected(old('theme_mode', $settings['theme_mode'] ?? '') == 'light')>Light</option>
            <option value="dark" @selected(old('theme_mode', $settings['theme_mode'] ?? '') == 'dark')>Dark</option>
            <option value="auto" @selected(old('theme_mode', $settings['theme_mode'] ?? '') == 'auto')>Auto</option>
        </select>
    </div>
    <div>
        <label class="block mb-1 text-sm font-medium">Maintenance Mode</label>
        <select name="maintenance_mode" class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <option value="off" @selected(old('maintenance_mode', $settings['maintenance_mode'] ?? 'off') === 'off')>Off</option>
            <option value="on" @selected(old('maintenance_mode', $settings['maintenance_mode'] ?? 'off') === 'on')>On</option>
        </select>
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Save Settings
        </button>
    </div>
</form>
@endsection
