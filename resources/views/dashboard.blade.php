@extends('layouts.app')

@section('content')
<div class="text-center mt-12">
    <h1 class="text-3xl font-bold mb-4">Welcome, {{ Auth::user()->name }}</h1>
    <p class="text-gray-600 dark:text-gray-300 mb-6">
        Your role is <strong>{{ ucfirst(Auth::user()->role->name) }}</strong>.
    </p>

    @if(in_array(Auth::user()->role->name, ['admin', 'employee']))
        <p class="text-lg">Use the navigation above to manage the system.</p>
    @else
        <p class="text-lg">Click below to get started with your dashboard.</p>
        <a href="/places" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Start Exploring
        </a>
    @endif
</div>
@endsection