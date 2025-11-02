@extends('layouts.app')

@section('content')
<div class="container">
    <h3>All Zoom Sessions</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->role=='teacher')
        <a href="{{ route('sessions.create') }}" class="btn btn-primary mb-3">Create New Session</a>
    @endif

    <ul class="list-group">
        @foreach($sessions as $session)
            <li class="list-group-item">
                <strong>{{ $session->topic }}</strong> |
                Starts at: {{ $session->start_time }} |
                Teacher: {{ $session->teacher->name }} |
                <a href="{{ $session->zoom_link }}" target="_blank" class="btn btn-success btn-sm">Join</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
