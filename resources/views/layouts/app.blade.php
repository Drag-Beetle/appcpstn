<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site_name') ?? config('app.name', 'Dashboard') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 
    @if ($theme_mode === 'dark') dark bg-gray-950 text-gray-100 
    @elseif ($theme_mode === 'auto') dark:bg-gray-950 dark:text-gray-100
    @endif
">
    <div class="flex flex-col min-h-screen">

        <!-- Top Navbar -->
        <header class="bg-white dark:bg-gray-900 text-black dark:text-white shadow p-4 flex justify-between items-center border-b">
            <div class="flex items-center gap-8">
                <span class="text-xl font-semibold">{{ setting('site_name') ?? 'Dashboard' }}</span>

                <!-- Desktop Navigation -->
                @if (Auth::check() && Auth::user()->isAdmin())
    <nav class="hidden md:flex items-center gap-2 text-sm font-medium">
        @php
            $navLinks = [
                ['name' => 'Dashboard', 'href' => '/admin', 'pattern' => 'admin*'],
                ['name' => 'Places', 'href' => '/places', 'pattern' => 'places*'],
                ['name' => 'Users', 'href' => '/users', 'pattern' => 'users*'],
                ['name' => 'Settings', 'href' => '/settings', 'pattern' => 'settings*'],
            ];
        @endphp

        @foreach ($navLinks as $link)
            <a href="{{ $link['href'] }}"
               class="px-3 py-2 rounded-lg transition-all duration-200 ease-in-out
                   {{ request()->is($link['pattern']) 
                       ? 'bg-gray-200 dark:bg-gray-800 text-black dark:text-white' 
                       : 'hover:bg-gray-200 dark:hover:bg-gray-800 hover:underline underline-offset-4 decoration-gray-400 text-gray-600 dark:text-gray-300' }}">
                {{ $link['name'] }}
            </a>
        @endforeach
    </nav>
@endif

                <!-- Mobile Navigation -->
                @if (Auth::check() && Auth::user()->isAdmin())
    <div x-data="{ open: false }" class="md:hidden relative">
        <button @click="open = !open" class="p-2 rounded border dark:border-gray-600">☰</button>
        <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded shadow p-2 z-50">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}"
                   class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm
                   {{ request()->is($link['pattern']) 
                       ? 'bg-gray-200 dark:bg-gray-700 text-black dark:text-white' 
                       : 'text-gray-700 dark:text-gray-300' }}">
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
    </div>
@endif

            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="relative">🔔
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="absolute top-0 right-0 block w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        @endif
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded shadow z-50">
                        <div class="p-2">
                            <h4 class="font-bold text-sm mb-2 text-gray-700 dark:text-white">Notifications</h4>
                            @foreach(auth()->user()->unreadNotifications->take(5) as $note)
                                <a href="{{ $note->data['url'] ?? '#' }}" class="block text-sm text-gray-700 dark:text-gray-200 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                                    {{ $note->data['title'] ?? 'Notification' }}
                                    <div class="text-xs text-gray-500">{{ $note->created_at->diffForHumans() }}</div>
                                </a>
                            @endforeach
                        </div>
                        <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                            <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-blue-500 hover:underline w-full text-center">Mark All As Read</button>
                            </form>
                        </div>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}" 
   class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 px-3 py-1 rounded text-sm">
   {{ Auth::user()->name }}
</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 hover:underline">Logout</button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-auto bg-white dark:bg-gray-900">

            {{-- Floating Success Toast --}}
            @if (session('success'))
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-cloak
                    class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50 transition"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- Inline Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Content Slot --}}
            @yield('content')

        </main>
    </div>
</body>
</html>
