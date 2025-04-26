<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ setting('site_name') ?? config('app.name', 'Dashboard') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-white">
    <div class="min-h-screen flex flex-col">

        <!-- Minimal Topbar -->
        <header class="bg-white dark:bg-gray-900 shadow p-4 flex justify-between items-center border-b">
            <span class="text-lg font-bold">{{ setting('site_name') ?? 'Tourism App' }}</span>

            <div class="flex items-center gap-4">
                <a href="{{ route('profile.edit') }}" class="text-sm font-medium hover:underline">
                    {{ Auth::user()->name }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 hover:underline text-sm">Logout</button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            {{-- Success Toast --}}
            @if (session('success'))
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-cloak
                    class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Actual Page --}}
            @yield('content')
        </main>
    </div>
</body>
</html>
