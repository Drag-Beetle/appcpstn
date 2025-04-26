@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold">Welcome, {{ ucfirst(Auth::user()->role->name) }}</h2>
<p>This is your role-specific dashboard.</p>
@endsection