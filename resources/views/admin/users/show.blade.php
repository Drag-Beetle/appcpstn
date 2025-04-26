@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">{{ $user->name }}'s Profile</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">User Details</h3>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role->name) }}</p>
        <p><strong>Status:</strong> {{ $user->is_active ? 'Active' : 'Inactive' }}</p>
        <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
        <p><strong>Last Login:</strong> {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'N/A' }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Places Created ({{ $places->count() }})</h3>
        <ul class="list-disc list-inside text-sm">
            @forelse($places as $place)
                <li>{{ $place->name }} <span class="text-gray-500">({{ $place->type }})</span></li>
            @empty
                <li class="text-gray-500">No places created.</li>
            @endforelse
        </ul>
    </div>
</div>
<div class="bg-white dark:bg-gray-800 p-6 rounded shadow col-span-2">
    <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
    <ul class="list-disc list-inside text-sm">
        @forelse($logs as $log)
            <li>{{ $log->created_at->diffForHumans() }} — {{ $log->action }}: {{ $log->description }}</li>
        @empty
            <li class="text-gray-500">No recent activity.</li>
        @endforelse
    </ul>
</div>
@endsection