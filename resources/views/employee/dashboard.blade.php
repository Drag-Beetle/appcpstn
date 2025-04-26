@extends('layouts.user')

@section('content')
    <h2 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600 mt-2">You are logged in as <strong>{{ Auth::user()->role->name }}</strong>.</p>
@endsection
